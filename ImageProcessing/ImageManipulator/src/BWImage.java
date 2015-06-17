import java.io.BufferedWriter;
import java.io.DataInputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileWriter;
import java.io.IOException;


public class BWImage extends Image
{
	private int imgSize;
	private int maxGreyLevel;
	public int[][] img= new int[imgSize][imgSize];

//-------------------------------------------------------------
//CONSTRUCTORS
//
//--------------------------------------------------------------
	public BWImage(String fileName, int size, int maxGrey) throws IOException
	{
		imgSize= size;
		maxGreyLevel= maxGrey;
		byte[] binImg= readDatFile(fileName);
		img= convertToIntArray(binImg, imgSize);
	}
	
	public BWImage(int[][] newImage, int maxGrey)
	{
		maxGreyLevel= maxGrey;
		imgSize= newImage.length;
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
	
	
    private static int[][] convertToIntArray(byte[] orig, int size)
    {
        int[][] newImg= new int[size][size];
        byte num;
        for(int i=0; i<size; i++)
        {

            for(int j= 0; j<size; j++)
            {
                num= orig[j+ i*size];
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
        out.write("256 256");
        out.newLine();
        out.write(String.valueOf(maxGreyLevel));
        out.newLine();
        
        System.out.println("Writing image to " + fileName);
            for(int i= 0; i< imgSize; i++)
            {
                for(int j= 0; j< imgSize; j++)
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
		int[][] equalize= new int[imgSize][imgSize];
		
		int[] pxVal= findValueArray(img);
		int[] equalArray= findEqualizedArray(pxVal);
		//replaces the original image's pixel value
		//with the value for the equalized image
		for(int i= 0; i<imgSize; i++)
		{
			for(int j= 0; j<imgSize; j++)
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
	
	public int[] findValueArray(int[][] image)
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
		for(int i= 0; i<imgSize; i++)
		{
			for(int j= 0; j<imgSize; j++)
			{
				pxValues[image[i][j]]++;
			}
		}
		return pxValues;		
	}
    
}
