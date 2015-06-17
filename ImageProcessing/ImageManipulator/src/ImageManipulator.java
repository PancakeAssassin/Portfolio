import java.io.IOException;


public class ImageManipulator
{
	public static void main(String[] args) throws IOException
	{
		BWImage lenna= new BWImage("lenna.dat", 256, 255);
		ColorImage model= new ColorImage("model.dat", 256, 256, 255);
		ColorImage batman= new ColorImage("batman.dat", 500, 400, 255);
		
		BWImage lennaInv= lenna.getInverse();
		BWImage lennaEq= lenna.equalizeImage();
		
		lenna.writeImgToFile("lenna");
		lennaInv.writeImgToFile("lennaInv");
		lennaEq.writeImgToFile("lennaEq");
		
		
		ColorImage modelInv= model.getInverse();
		ColorImage modelEq= model.equalizeImage();
		
		model.writeImgToFile("model");
		modelInv.writeImgToFile("modelInv");
		modelEq.writeImgToFile("modelEq");
		
		ColorImage batmanInv= batman.getInverse();
		ColorImage batmanEq= batman.equalizeImage();
		
		batman.writeImgToFile("batman");
		batmanInv.writeImgToFile("batmanInv");
		batmanEq.writeImgToFile("batmanEq");
		
	}
}