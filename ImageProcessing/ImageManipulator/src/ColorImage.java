//Class for color images
import java.io.BufferedWriter;
import java.io.DataInputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileWriter;
import java.io.IOException;


public class ColorImage extends Image{
	private int width, height;
	private int maxIntensity;
	public int[][][] img = new int[3][width][height];

	// -------------------------------------------------------------
	// CONSTRUCTORS
	//
	// --------------------------------------------------------------
	public ColorImage(String fileName, int w, int h, int intensity) throws IOException {
		width = w;
		height= h;
		maxIntensity = intensity;
		byte[] binImg = readDatFile(fileName);
		img = convertToIntArray(binImg, w, h);
	}

	public ColorImage(int[][][] newImage, int intensity) {
		maxIntensity = intensity;
		width= newImage[0].length;
		height= newImage[0][0].length;
		img = newImage;
	}

	// -----------------------------------------------------------------------
	// SETTERS && GETTERS
	//
	// -----------------------------------------------------------------------
	public int getMaxIntensity() {
		return maxIntensity;
	}

	public void setMaxGreyLevel(int intensity) {
		maxIntensity = intensity;
	}

	// ------------------------------------------------------------
	// READ FUNCTIONS for a binary image file
	//
	// ------------------------------------------------------------
	protected byte[] readDatFile(String fileName) throws IOException {
		// open the dat file for image
		FileInputStream fstream = new FileInputStream(fileName);

		// get the DataInputStream Object
		DataInputStream in = new DataInputStream(fstream);

		File inputfile = new File(fileName);
		byte[] result = new byte[(int) inputfile.length()];

		int totalBytesRead = 0;
		// read each line in the file
		while (totalBytesRead < result.length) {
			int bytesLeft = result.length - totalBytesRead;
			int bytesRead = in.read(result, totalBytesRead, bytesLeft);

			if (bytesRead > 0) {
				totalBytesRead = totalBytesRead + bytesRead;
			}
		}

		// close the input and output stream
		in.close();

		return result;
	}

	private static int[][][] convertToIntArray(byte[] orig, int w, int h) {
		int[][][] newImg = new int[3][w][h];
		byte num;
		for (int i = 0; i < w; i++) {
			for (int j = 0; j < h; j++) {
				num = orig[3* (j + i * h)];
				newImg[0][i][j] = byteToInt(num);
				num = orig[3 * (j + i * h) + 1];
				newImg[1][i][j] = byteToInt(num);
				num = orig[3 * (j + i * h) + 2];
				newImg[2][i][j] = byteToInt(num);
			}
		}

		return newImg;
	}

	private static int byteToInt(byte b) {

		return (b & 0xFF);
	}

	// ---------------------------------------------------------------
	// WRITE IMAGE to file
	//
	// ---------------------------------------------------------------
	public boolean writeImgToFile(String name) throws IOException {
		String fileName = name + ".ppm";
		FileWriter fwstream = new FileWriter(fileName);
		BufferedWriter out = new BufferedWriter(fwstream);

		out.write("P3");
		out.newLine();
		out.write(String.valueOf(width));
		out.write(" ");
		out.write(String.valueOf(height));
		out.newLine();
		out.write(String.valueOf(maxIntensity));
		out.newLine();

		System.out.println("Writing image to " + fileName);
		for (int i = 0; i < width; i++) {
			for (int j = 0; j < height; j++) {
				out.write(String.valueOf(img[0][i][j]));
				out.write(" ");
				out.write(String.valueOf(img[1][i][j]));
				out.write(" ");
				out.write(String.valueOf(img[2][i][j]));
				out.write(" ");
			}
			out.newLine();
		}
		out.close();

		return true;
	}

	// ---------------------------------------------------------------
	// IMAGE INVERSION Function
	//
	// ---------------------------------------------------------------
	public ColorImage getInverse() {
		int[][][] inverse = new int[3][img[0].length][img[0][0].length];

		// apply algorithm to invert the image
		// algorithm: inversepxValue= maxGreyLevel - originalpxValue
		for (int i = 0; i < img[0].length; i++) {
			for (int j = 0; j < img[0][0].length; j++) {
				inverse[0][i][j] = maxIntensity - img[0][i][j];
				inverse[1][i][j] = maxIntensity - img[1][i][j];
				inverse[2][i][j] = maxIntensity - img[2][i][j];
			}
		}
		ColorImage invImage = new ColorImage(inverse, this.getMaxIntensity());

		return invImage;
	}

	// ---------------------------------------------------------------
	// IMAGE EQUALIZATION Functions
	//
	// ---------------------------------------------------------------
	public ColorImage equalizeImage() {
		int[][][] equalize = new int[3][width][height];
		
		int[] pxValR = findValueArray(img[0]);
		int[] pxValG = findValueArray(img[1]);
		int[] pxValB = findValueArray(img[2]);
		
		int[] equalArrayR = findEqualizedArray(pxValR);
		int[] equalArrayG = findEqualizedArray(pxValG);
		int[] equalArrayB = findEqualizedArray(pxValB);
		// replaces the original image's pixel value
		// with the value for the equalized image
		for (int i = 0; i < width; i++) {
			for (int j = 0; j < height; j++) {
				equalize[0][i][j] = equalArrayR[img[0][i][j]];
				equalize[1][i][j] = equalArrayG[img[1][i][j]];
				equalize[2][i][j] = equalArrayB[img[2][i][j]];
			}
		}

		ColorImage equalizedImage = new ColorImage(equalize, this.getMaxIntensity());

		return equalizedImage;
	}

	protected int[] findEqualizedArray(int[] pxValues) {
		float[] runSum = new float[maxIntensity + 1];
		int[] equalizer = new int[maxIntensity + 1];
		int numOfPixels = 0;
		int runningSum = 0;

		// find the total number of pixels
		for (int i = 0; i < pxValues.length; i++) {
			numOfPixels += pxValues[i];
		}

		for (int i = 0; i < pxValues.length; i++) {
			runningSum = pxValues[i] + runningSum;
			runSum[i] = runningSum;
		}
		// divide the number of pixels which
		for (int i = 0; i < pxValues.length; i++) {
			equalizer[i] = (int) ((runSum[i] / numOfPixels) * (maxIntensity));
		}

		return equalizer;
	}

	public int[] findValueArray(int image[][]) {
		int[] pxValues = new int[maxIntensity + 1];
		// set the pixel value array to 0
		for (int i = 0; i < pxValues.length; i++) {
			pxValues[i] = 0;
		}

		// increment the value where the index of pxValue
		// equals that of the current pixel being examined
		// in imgArray
		for (int i = 0; i < width; i++) {
			for (int j = 0; j < height; j++) {
				pxValues[image[i][j]]++;
			}
		}
		return pxValues;
	}

}
