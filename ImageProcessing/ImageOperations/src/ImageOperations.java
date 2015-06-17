import java.io.IOException;


public class ImageOperations 
{

	public static void main(String[] args) throws IOException
	{
		BWImage lenna= new BWImage("lenna.dat", 256, 255);
		BWImage flower= new BWImage("flower.dat", 512, 512, 255);
		BWImage dude= new BWImage("dude.dat", 450, 300, 255);
		
		BWImage lennaRot90= BWImage.rotate(lenna, 90);
		BWImage lennaRot180= BWImage.rotate(lenna, 180);
		BWImage lennaRot270= BWImage.rotate(lenna, 270);
		BWImage flowerRot90= BWImage.rotate(flower, 90);
		BWImage flowerRot180= BWImage.rotate(flower, 180);
		BWImage flowerRot270= BWImage.rotate(flower, 270);
		
		BWImage dudeRot90= BWImage.rotate(dude, 90);
		
		
		BWImage lennaVert= lenna.FlipVertical();
		BWImage lennaHor= lenna.FlipHorizontal();
		BWImage flowerVert= flower.FlipVertical();
		BWImage flowerHor= flower.FlipHorizontal();
		BWImage dudeHor= dude.FlipHorizontal();
		
		BWImage lennaMagR= lenna.MagnifyR(2);
		BWImage lennaMagI= lenna.MagnifyI(2);
		BWImage flowerMagR= flower.MagnifyR(2);
		BWImage flowerMagI= flower.MagnifyI(2);
		
		BWImage lennaRedS= lenna.Reduction(2);
		BWImage lennaRedA= lenna.ReductionA(2);
		BWImage lennaRedM= lenna.ReductionM(2);
		BWImage flowerRedS= flower.Reduction(2);
		BWImage flowerRedA= flower.ReductionA(2);
		BWImage flowerRedM= flower.ReductionM(2);
		
		lenna.writeImgToFile("pics\\orig\\lenna");
		lennaRot90.writeImgToFile("pics\\lenna90");
		lennaRot180.writeImgToFile("pics\\lenna180");
		lennaRot270.writeImgToFile("pics\\lenna270");
		lennaVert.writeImgToFile("pics\\lennaVert");
		lennaHor.writeImgToFile("pics\\lennaHor");
		lennaMagR.writeImgToFile("pics\\lennaMagnifyReplication");
		lennaMagI.writeImgToFile("pics\\lennaMagnifyInterpolation");
		lennaRedS.writeImgToFile("pics\\lennaReduceSimple");
		lennaRedA.writeImgToFile("pics\\lennaReduceAverage");
		lennaRedM.writeImgToFile("pics\\lennaReduceMedian");
		

		flower.writeImgToFile("pics\\orig\\flower");
		flowerRot90.writeImgToFile("pics\\flower90");
		flowerRot180.writeImgToFile("pics\\flower180");
		flowerRot270.writeImgToFile("pics\\flower270");
		flowerVert.writeImgToFile("pics\\flowerVert");
		flowerHor.writeImgToFile("pics\\flowerHor");
		flowerMagR.writeImgToFile("pics\\flowerMagnifyReplication");
		flowerMagI.writeImgToFile("pics\\flowerMagnifyInterpolation");
		flowerRedS.writeImgToFile("pics\\flowerReduceSimple");
		flowerRedA.writeImgToFile("pics\\flowerReduceAverage");
		flowerRedM.writeImgToFile("pics\\flowerReduceMedian");
		
		dude.writeImgToFile("pics\\orig\\dude");
		dudeRot90.writeImgToFile("pics\\dudeRot90");
		dudeHor.writeImgToFile("pics\\dudeHor");
	}
}
