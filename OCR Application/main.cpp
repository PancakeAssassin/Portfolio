#include <tesseract/baseapi.h>
#include <tesseract/strngs.h>
#include <opencv2/core/core.hpp>
#include <opencv2/highgui/highgui.hpp>
#include <opencv2/photo/photo.hpp>
#include <regex>
#include <iostream>
#include <string>

static void FindRectangles(const cv::Mat& image, std::vector<std::vector<cv::Point> >& squares);
static void DrawRectangles(cv::Mat& image, const std::vector<std::vector<cv::Point> >& squares);
static double angle(cv::Point pt1, cv::Point pt2, cv::Point pt0);
static std::vector<cv::Mat> CreateRectangleImages(cv::Mat image, std::vector<std::vector<cv::Point> >& squares);
static std::string ExtractText(cv::Mat image);

int main(int argc, char** argv)
{
	
	std::cout << "Enter the name of the image file you would like to have text read from: ";
	std::string filename;
	std::cin >> filename;
	std::cout << std::endl;
	cv::Mat image;
	image = cv::imread(filename);
	if (image.empty())
	{
		std::cout << "Cannot open source image" << std::endl;
	}
	cv::Mat blur;
	cv::GaussianBlur(image, blur, cv::Size(9, 9), 0);
	
	cv::Mat element = cv::getStructuringElement(0, cv::Size(256, 256));
	cv::morphologyEx(blur, blur, CV_MOP_TOPHAT, element);
	threshold(blur , blur, 127, 255, CV_THRESH_BINARY);
	//find rectangles that may contain the liscense plate
	std::vector<std::vector<cv::Point>> squares;
	FindRectangles(blur, squares);
	DrawRectangles(blur , squares);
	std::vector<cv::Mat> images= CreateRectangleImages(image, squares);

	if (images.size() < 1)
	{
		std::string out = ExtractText(image);
		std::cout << out << std::endl;
	}
	else
	{
		for (int i = 0; i < images.size(); i++)
		{
			std::string out = ExtractText(images[i]);
			std::cout << out << std::endl;
		}
	}

	system("PAUSE");


	return 0;
}

static void FindRectangles(const cv::Mat& image, std::vector<std::vector<cv::Point> >& squares)
{
	int N = 11;
	int thresh = 50;
	squares.clear();

	cv::Mat pyr, timg, gray0(image.size(), CV_8U), gray;

	// down-scale and upscale the image to filter out the noise
	pyrDown(image, pyr, cv::Size(image.cols / 2, image.rows / 2));
	pyrUp(pyr, timg, image.size());
	std::vector<std::vector<cv::Point> > contours;

	// find squares in every color plane of the image
	for (int c = 0; c < 3; c++)
	{
		int ch[] = { c, 0 };
		cv::mixChannels(&timg, 1, &gray0, 1, ch, 1);

		// try several threshold levels
		for (int l = 0; l < N; l++)
		{
			
			// Canny helps to catch squares with gradient shading
			if (l == 0)
			{
				// Apply Canny. Take the upper threshold from slider
				// and set the lower to 0
				cv::Canny(gray0, gray, 0, thresh, 5);
				// Dilate canny output to remove potential
				// holes between edge segments
				cv::dilate(gray, gray, cv::Mat(), cv::Point(-1, -1));
			}
			else
			{
				// Apply threshold if l!=0:
				//     tgray(x,y) = gray(x,y) < (l+1)*255/N ? 255 : 0
				gray = gray0 >= (l + 1) * 255 / N;
			}

			// find contours and store them all as a list
			cv::findContours(gray, contours, CV_RETR_LIST, CV_CHAIN_APPROX_SIMPLE);

			std::vector<cv::Point> approx;

			// test each contour
			for (size_t i = 0; i < contours.size(); i++)
			{
				// approximate contour with accuracy proportional
				// to the contour perimeter
				cv::approxPolyDP(cv::Mat(contours[i]), approx, cv::arcLength(cv::Mat(contours[i]), true)*0.02, true);

				// square contours should have 4 vertices after approximation
				// relatively large area (to filter out noisy contours)
				// and be convex.
				// Note: absolute value of an area is used because
				// area may be positive or negative - in accordance with the
				// contour orientation
				if (approx.size() == 4 &&
					fabs(cv::contourArea(cv::Mat(approx))) > 1000 &&
					cv::isContourConvex(cv::Mat(approx)))
				{
					double maxCosine = 0;

					for (int j = 2; j < 5; j++)
					{
						// find the maximum cosine of the angle between joint edges
						double cosine = fabs(angle(approx[j % 4], approx[j - 2], approx[j - 1]));
						maxCosine = MAX(maxCosine, cosine);
					}

					// if cosines of all angles are small
					// (all angles are ~90 degree) then write quandrange
					// vertices to resultant sequence
					if (maxCosine < 0.3)
						squares.push_back(approx);
				}
			}
		}
	}
}

static void DrawRectangles(cv::Mat& image, const std::vector<std::vector<cv::Point> >& squares)
{
	for (size_t i = 0; i < squares.size(); i++)
	{
		const cv::Point* p = &squares[i][0];
		int n = (int)squares[i].size();
		polylines(image, &p, &n, 1, true, cv::Scalar(0, 255, 0), 3, CV_AA);
	}

	imwrite("Rectangles.jpg", image);
	imshow("Rectangles", image);
	cv::waitKey(10);
}

static double angle(cv::Point pt1, cv::Point pt2, cv::Point pt0)
{
	double dx1 = pt1.x - pt0.x;
	double dy1 = pt1.y - pt0.y;
	double dx2 = pt2.x - pt0.x;
	double dy2 = pt2.y - pt0.y;
	return (dx1*dx2 + dy1*dy2) / sqrt((dx1*dx1 + dy1*dy1)*(dx2*dx2 + dy2*dy2) + 1e-10);
}

static std::vector<cv::Mat> CreateRectangleImages(cv::Mat image, std::vector<std::vector<cv::Point>>& squares)
{
	std::vector<cv::Mat> images;
	
	for (size_t i = 0; i < squares.size(); i++)
	{
		int upperLeft = 0;
		int lowerRight = 0;
		//find the upperLeft and lowerRight points for the current square
		for (int j = 0; j < squares[i].size(); j++)
		{
			if (squares[i][j].x < squares[i][upperLeft].x)
			{
				upperLeft = j;
			}
			else if (squares[i][j].x > squares[i][lowerRight].x)
			{
				lowerRight = j;
			}
		}
		cv::Mat newImg(image, cv::Rect(squares[i][upperLeft], squares[i][lowerRight]));
		images.push_back(newImg);
		std::string imgName = "imgSq" + std::to_string(i);
		imgName.append(".jpg");
		imwrite(imgName, newImg);
	}
	


	return images;
}

static std::string ExtractText(cv::Mat image)
{
	const char* lang = "eng";

	cv::Mat gray;
	cv::Mat blur;

	cv::cvtColor(image, gray, CV_BGR2GRAY);

	cv::Mat thresholdImage;
	//threshold(gray, thresholdImage, 127, 255, CV_THRESH_BINARY_INV);
	//adaptiveThreshold(thresholdImage, thresholdImage, 255, CV_ADAPTIVE_THRESH_GAUSSIAN_C, CV_THRESH_BINARY, 11, 2);

	
	cv::GaussianBlur(gray, blur, cv::Size(5, 5), 0);
	threshold(blur, thresholdImage, 0, 255, CV_THRESH_BINARY + CV_THRESH_OTSU);

	//fastNlMeansDenoising(thresholdImage, thresholdImage);

	cv::imwrite("output.jpg", thresholdImage);

	if (thresholdImage.empty())
		return "";

	tesseract::TessBaseAPI tess;
	tess.Init(NULL, lang, tesseract::OEM_DEFAULT);
	tess.SetPageSegMode(tesseract::PSM_SINGLE_BLOCK);
	tess.SetImage((uchar*)thresholdImage.data, thresholdImage.cols, thresholdImage.rows, 1, thresholdImage.cols);

	std::string out = tess.GetUTF8Text();
	std::string output = "";

	for (int i = 0; i < out.length(); i++)
	{
		std::string temp = "";
		temp+=out[i];
		if (std::regex_match(temp, std::regex("^[A-Za-z0-9]+$")))
		{
			output+=out[i];
		}
	} 

	return output;
}