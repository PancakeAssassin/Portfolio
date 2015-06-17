import java.io.IOException;


public abstract class Image 
{
//------------------------------------------------------------
//READ FUNCTIONS for a binary image file
//
//------------------------------------------------------------
	protected abstract byte[] readDatFile(String fileName) throws IOException;
	
    
//---------------------------------------------------------------
//WRITE IMAGE to file
//
//---------------------------------------------------------------
    abstract boolean writeImgToFile(String name) throws IOException;
    
//---------------------------------------------------------------
//IMAGE INVERSION Function
//
//---------------------------------------------------------------
    abstract Image getInverse();
    
//---------------------------------------------------------------    
//IMAGE EQUALIZATION Functions
//
//---------------------------------------------------------------
    abstract Image equalizeImage();
    
	abstract int[] findEqualizedArray(int[] pxValues);
		
	abstract int[] findValueArray(int img[][]);
    
}
