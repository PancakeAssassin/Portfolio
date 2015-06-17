import java.io.BufferedWriter;
import java.io.DataInputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileWriter;
import java.io.IOException;
import java.util.Arrays;


public class BWImage
{
	private int width, height;
	private int maxGreyLevel;
	public int[][] img;

//-------------------------------------------------------------
//CONSTRUCTORS
//
//--------------------------------------------------------------
	//if the image is square
	public BWImage(String fileName, int size, int maxGrey) throws IOException
	{
		width= size;
		height= size;
		maxGreyLevel= maxGrey;
		byte[] binImg= readDatFile(fileName);
		img= new int[width][height];
		img= convertToIntArray(binImg, width, height);
	}
	
	//rectangular size
	public BWImage(String fileName, int w, int h, int maxGrey) throws IOException
	{
		width= w;
		height= h;
		maxGreyLevel= maxGrey;
		byte[] binImg= readDatFile(fileName);
		img= new int[width][height];
		img= convertToIntArray(binImg, width, height);
	}
	
	public BWImage(int[][] newImage, int maxGrey)
	{
		maxGreyLevel= maxGrey;
		width= newImage.length;
		height= newImage[0].length;
		img = new int[width][height];
		img= newImage;
	}

//-----------------------------------------------------------------------
//SETTERS && GETTERS
//
//-----------------------------------------------------------------------
	public int getMaxGreyLevel()
	{
		return maxGreyLevel;
	}
	
	public void setMaxGreyLevel(int grey)
	{
		maxGreyLevel= grey;
	}
//------------------------------------------------------------
//READ FUNCTIONS for a binary image file
//
//------------------------------------------------------------
	protected byte[] readDatFile(String fileName) throws IOException
	{
		//open the dat file for image
		FileInputStream fstream= new FileInputStream(fileName);
		                
		//get the DataInputStream Object
		DataInputStream in = new DataInputStream(fstream);
		               
		File inputfile= new File(fileName);
		byte[] result= new byte[(int)inputfile.length()];
		            
		int totalBytesRead= 0;
		//read each line in the file
		while(totalBytesRead < result.length)
		{
			int bytesLeft= result.length - totalBytesRead;
		    int bytesRead= in.read(result, totalBytesRead, bytesLeft);
		                
		    if(bytesRead > 0)
		    {
		    	totalBytesRead= totalBytesRead + bytesRead;
		    }
		 }
		
		//close the input and output stream
		in.close();
		        
		return result;
	}
	
	
    private static int[][] convertToIntArray(byte[] orig, int w, int h)
    {
        int[][] newImg= new int[w][h];
        byte num;
        for(int i=0; i<w; i++)
        {
            for(int j= 0; j<h; j++)
            {
                num= orig[j+ i*h];
                //make sure j does not go out of bounds of the array
                newImg[i][j]= byteToInt(num);
            }
        }
    
        return newImg;
    }
    
    private static int byteToInt(byte b) 
    {

        return (b & 0xFF);
    }
//---------------------------------------------------------------
//WRITE IMAGE to file
//
//---------------------------------------------------------------
    public boolean writeImgToFile(String name) throws IOException
    {
    	String fileName= name + ".pgm";
        FileWriter fwstream= new FileWriter(fileName);
        BufferedWriter out= new BufferedWriter(fwstream);
        
        out.write("P2");
        out.newLine();
        out.write(String.valueOf(width));
		out.write(" ");
		out.write(String.valueOf(height));
        out.newLine();
        out.write(String.valueOf(maxGreyLevel));
        out.newLine();
        
        System.out.println("Writing image to " + fileName);
            for(int i= 0; i< width; i++)
            {
                for(int j= 0; j< height; j++)
                {
                    out.write(String.valueOf(img[i][j]));
                    out.write(" ");
                }
                out.newLine();
            }
            out.close();
        
        return true;
    }  
//---------------------------------------------------------------
//IMAGE INVERSION Function
//
//---------------------------------------------------------------
    public BWImage getInverse()
    {
		int[][] inverse= new int[img.length][img[0].length];
				
		//apply algorithm to invert the image
		//algorithm: inversepxValue= maxGreyLevel - originalpxValue
		for(int i= 0; i< img.length; i++)
		{
			for(int j= 0; j< img[0].length; j++)
			{
				inverse[i][j]= maxGreyLevel - img[i][j];
			}
		}
		BWImage invImage= new BWImage(inverse, this.getMaxGreyLevel());
		
		return invImage;    	
    }
//---------------------------------------------------------------    
//IMAGE EQUALIZATION Functions
//
//---------------------------------------------------------------
    public BWImage equalizeImage()
    {
		int[][] equalize= new int[width][height];
		
		int[] pxVal= findValueArray();
		int[] equalArray= findEqualizedArray(pxVal);
		//replaces the original image's pixel value
		//with the value for the equalized image
		for(int i= 0; i<width; i++)
		{
			for(int j= 0; j<height; j++)
			{
				equalize[i][j]= equalArray[img[i][j]];
			}
		}
		
		BWImage equalizedImage= new BWImage(equalize, this.getMaxGreyLevel());
		
		return equalizedImage;
    }
    
	protected int[] findEqualizedArray(int[] pxValues)
	{
		float[] runSum= new float[maxGreyLevel+1];
		int[] equalizer= new int[maxGreyLevel+1];
		int numOfPixels= 0;
		int runningSum= 0;
		
		//find the total number of pixels
		for(int i= 0; i< pxValues.length; i++)
		{
			numOfPixels+= pxValues[i];
		}
		
		for(int i= 0; i< pxValues.length; i++)
		{
			runningSum= pxValues[i] + runningSum;
			runSum[i]= runningSum;
		}
		//divide the number of pixels which
		for(int i= 0; i< pxValues.length; i++)
		{
			equalizer[i]= (int)((runSum[i]/numOfPixels)*(maxGreyLevel));
		}
		
		return equalizer;
	}
	
	public int[] findValueArray()
	{
		int[] pxValues= new int[maxGreyLevel+1];
		//set the pixel value array to 0
		for(int i= 0; i< pxValues.length; i++)
		{
			pxValues[i]= 0;
		}
				
		//increment the value where the index of pxValue
		//equals that of the current pixel being examined
		//in imgArray
		for(int i= 0; i<width; i++)
		{
			for(int j= 0; j<height; j++)
			{
				pxValues[img[i][j]]++;
			}
		}
		return pxValues;		
	}


	public BWImage convolute2D(float[][] MK, boolean isLow)
	{
		int[][] imgO= new int[width][height];
		float coeff= 1;
		
		if(isLow)
			coeff= findCoeff(MK);
		
		System.out.println("The coeff is: " + coeff);
		
		for(int i= 0; i< width; i++)
		{
			for(int j= 0; j< height; j++)
			{
				imgO[i][j]= convolve(MK, i, j);
				
				imgO[i][j]= (int) (coeff * imgO[i][j]);
				
				if(imgO[i][j] > maxGreyLevel-1)
					imgO[i][j] = maxGreyLevel-1;
				else if(imgO[i][j] < 0)
					imgO[i][j] = 0;
			}
		}
		
		
		BWImage o = new BWImage(imgO, maxGreyLevel);
		
		return o;
	}
	
	public BWImage runMedianFilter(int filterSize)
	{
		int[][] imgO= new int[width][height];
		
		for(int i= 0; i < width; i++)
		{
			for(int j = 0; j< height; j++)
			{
				imgO[i][j]= findMedian(i, j , filterSize);
			}
		}
		BWImage med= new BWImage(imgO, maxGreyLevel);
		return med;
	}
	
	public int findMedian(int x, int y, int filterSize)
	{
		int[] theNumbers= new int[filterSize * filterSize];
		int num= 0;
		int fSize= filterSize/2;
		for(int i= -fSize; i <= fSize; i++)
		{
		 	for(int j = -fSize; j <= fSize; j++)
			{
		 		int imageX= x + i;
		 		int imageY= y + j;
		 		
		 		if(imageX < 0)
		 			imageX= 0;
		 		else if(imageX >= width)
		 			imageX = width - 1;
		 		
		 		if(imageY < 0)
		 			imageY= 0;
		 		else if(imageY >= height)
		 			imageY= height - 1;
		 		
				theNumbers[num]= img[imageX][imageY];
				num++;
			}
		}
		
		bubbleSort(theNumbers);
		
		int median= theNumbers[(theNumbers.length /2)];
		
		return median;
	}
	
	public static void bubbleSort(int[] theArray)
	{
		int j;
		boolean flag = true;   // set flag to true to begin first pass
		int temp;   //holding variable

		while ( flag )
		{
			flag= false;    //set flag to false awaiting a possible swap
		    for( j=0;  j < theArray.length -1;  j++ )
		    {
		    	if ( theArray[ j ] < theArray[j+1] )   // change to > for ascending sort
		        {
		    		temp = theArray[ j ];                //swap elements
		            theArray[ j ] = theArray[ j+1 ];
		            theArray[ j+1 ] = temp;
		            flag = true;              //shows a swap occurred  
		        } 
		    } 
		}
	}
	
	static float findCoeff(float[][] MK)
	{
		float sum= 0;
		
		for(int i= 0; i < MK.length; i++)
		{
			for(int j = 0; j < MK[i].length; j++)
			{
				sum += MK[i][j];
			}
		}
		if(sum == 0)
			sum= 1;
		
		float coeff= 1 / sum;
				
		return coeff;
	}
	

	public int convolve(float[][] MK, int x, int y)
	{
		int summation=0;
		int fSize= MK.length/2;
		for(int i= -fSize; i<= fSize; i++)
		{
			for(int j= -fSize; j<=fSize; j++)
			{	   
				int imageX= x-i;
				int imageY= y-j;
				
				if(imageX < 0)
					imageX= 0;
				else if(imageX >= width)
					imageX= width -1;
				if(imageY < 0)
					imageY = 0;
				else if(imageY >= height)
					imageY = height- 1;
				
				summation+= img[imageX][imageY]*MK[i+fSize][j+fSize];
			}
		}
		return summation;
	}
	
	//using a high boost filter
	public BWImage HighBoostPass(double alpha)
	{
		
		float[][] filter= HighBoostMaskFilterImg(alpha);
		
		BWImage highBoostImg= convolute2D(filter, false);
		
		return highBoostImg;
	}
	
	
	//Find the high boost filter
	public static float[][] HighBoostMaskFilterImg(double alpha)
	{
		
		float[][] filter= {{-1, -1, -1},
						  {-1, 0, -1},
						  {-1, -1, -1}};
		
		filter[1][1]= (float) (9 * alpha - 1);
		
		return filter;
	}
}
