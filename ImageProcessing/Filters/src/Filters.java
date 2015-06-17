import java.io.IOException;

import jxl.write.WriteException;
import jxl.write.biff.RowsExceededException;


public class Filters 
{
	public static void main(String[] args) throws IOException, RowsExceededException, WriteException
	{
		
		//--------------------------------------------------------------------------------------
		//Low Pass		
		float[][] lowPassFilter= { {1, 2, 1},
								 {2, 4, 2},
								 {1, 2, 1}};
		float[][] lowPassOtherFilter= {{0, 1, 0},
									{1, 5, 1},
									{0, 1, 0}};
		
		
		histogram Lena1= new histogram("Lena1");
		BWImage lenaNoiseImg1 = new BWImage("lena_noise_1.dat", 347, 345, 256);
		lenaNoiseImg1.writeImgToFile("pics\\orig\\lenaNoise1");
		Lena1.createImageSheet(lenaNoiseImg1, "Original", 0);
		
		BWImage lenaLowPass1 = lenaNoiseImg1.convolute2D(lowPassFilter, true);
		lenaLowPass1.writeImgToFile("pics\\LenaLowPass1");
		Lena1.createImageSheet(lenaLowPass1, "Low Pass", 1);
		
		histogram Lena2= new histogram("Lena2");
		BWImage lenaNoiseImg2 = new BWImage("lena_noise_2.dat", 256, 256);
		lenaNoiseImg2.writeImgToFile("pics\\orig\\lenaNoise2");
		Lena2.createImageSheet(lenaNoiseImg2, "Original", 0);
		
		BWImage lenaLowPass2 = lenaNoiseImg2.convolute2D(lowPassFilter, true);
		lenaLowPass2.writeImgToFile("pics\\LenaLowPass2");
		Lena2.createImageSheet(lenaLowPass2, "Low Pass", 1);
		
		histogram dudeH= new histogram("dude");
		BWImage dude = new BWImage("dude.dat", 450, 300, 256);
		dude.writeImgToFile("pics\\orig\\dude");
		dudeH.createImageSheet(dude, "Original", 0);
		
		BWImage dudeLow = dude.convolute2D(lowPassOtherFilter, true);
		dudeLow.writeImgToFile("pics\\dudeLow");
		dudeH.createImageSheet(dudeLow, "Low Pass", 1);
		 
		//------------------------------------------------------------------------------------
		
		
		//--------------------------------------------------------------------------------------
		//High Pass
		float[][] highPassFilter = {{0, -1, 0},
								  {-1,  5, -1},
								  {0, -1, 0}};
		
		float[][] highPassFilter2 = {{-1, -1, -1},
									   {-1, 9, -1},
									   {-1, -1, -1}};
		
		histogram house= new histogram("house");
		BWImage houseBeforePass = new BWImage("house-High-pass.dat", 256, 256);
		houseBeforePass.writeImgToFile("pics\\orig\\house");
		house.createImageSheet(houseBeforePass, "Original", 0);
		
		BWImage houseHighPass= houseBeforePass.convolute2D(highPassFilter, false);
		houseHighPass.writeImgToFile("pics\\highPassHouse");
		house.createImageSheet(houseHighPass, "High Pass", 1);
		
		histogram clock= new histogram("clock");
		BWImage clockBeforePass = new BWImage("Hir-P5-794x626-High-Pass.dat", 794, 626, 256);
		clockBeforePass.writeImgToFile("pics\\orig\\clock");
		clock.createImageSheet(clockBeforePass, "Original", 0);
		
		BWImage clockHighPass= clockBeforePass.convolute2D(highPassFilter, false);
		clockHighPass.writeImgToFile("pics\\clockHighPass");
		clock.createImageSheet(clockHighPass, "High Pass", 1);
		
		histogram galaxy= new histogram("galaxy");
		BWImage galaxyBeforePass = new BWImage("galaxy.dat", 350, 252, 256);
		galaxyBeforePass.writeImgToFile("pics\\orig\\galaxy");
		galaxy.createImageSheet(galaxyBeforePass, "Original", 0);
		
		BWImage galaxyHighPass= galaxyBeforePass.convolute2D(highPassFilter, false);
		galaxyHighPass.writeImgToFile("pics\\galaxyHighPass");
		galaxy.createImageSheet(galaxyHighPass, "High Pass", 1);
		//----------------------------------------------------------------------------------------
		
		
		
		//-----------------------------------------------------------------------------------------
		//Median filter
		BWImage medianLena1= lenaNoiseImg1.runMedianFilter(5);
		medianLena1.writeImgToFile("pics\\medianLena1");
		Lena1.createImageSheet(medianLena1, "Median", 2);
		
		BWImage medianLena2= lenaNoiseImg2.runMedianFilter(5);
		medianLena2.writeImgToFile("pics\\medianLena2");
		Lena2.createImageSheet(medianLena2, "Median", 2);
		
		BWImage galaxyMedian= galaxyBeforePass.runMedianFilter(5);
		galaxyMedian.writeImgToFile("pics\\medianGalaxy");
		galaxy.createImageSheet(galaxyMedian, "Median", 2);
		//-------------------------------------------------------------------------------------------
		
		
		//-------------------------------------------------------------------------------------------
		//HighBoost filter
		double alpha1= 1.4;
		double alpha2= 1.2;
		
		BWImage highBoostHouse1= houseBeforePass.HighBoostPass(alpha1);
		highBoostHouse1.writeImgToFile("pics\\HighBoostHouse1");
		house.createImageSheet(highBoostHouse1, "HighBoost1", 2);
		
		BWImage highBoostHouse2= houseBeforePass.HighBoostPass(alpha2);
		highBoostHouse2.writeImgToFile("pics\\HighBoostHouse2");
		house.createImageSheet(highBoostHouse2, "HighBoost2", 3);
		
		
		BWImage highBoostClock1= clockBeforePass.HighBoostPass(alpha1);
		highBoostClock1.writeImgToFile("pics\\HighBoostClock1");
		clock.createImageSheet(highBoostClock1, "HighBoost1", 2);
		
		BWImage highBoostClock2= clockBeforePass.HighBoostPass(alpha2);
		highBoostClock2.writeImgToFile("pics\\HighBoostClock2");
		clock.createImageSheet(highBoostClock2, "HighBoost2", 3);
		
		BWImage highBoostGalaxy1= galaxyBeforePass.HighBoostPass(alpha1);
		highBoostGalaxy1.writeImgToFile("pics\\HighBoostGalaxy1");
		galaxy.createImageSheet(highBoostGalaxy1, "HighBoost1", 2);
		
		BWImage highBoostGalaxy2= galaxyBeforePass.HighBoostPass(alpha2);
		highBoostGalaxy2.writeImgToFile("pics\\HighBoostGalaxy2");
		galaxy.createImageSheet(highBoostGalaxy2, "HighBoost2", 3);
		//-------------------------------------------------------------------------------------------
		Lena1.writeFile();
		Lena1.closeFile();
		Lena2.writeFile();
		Lena2.closeFile();
		dudeH.writeFile();
		dudeH.closeFile();
		house.writeFile();
		house.closeFile();
		clock.writeFile();
		clock.closeFile();
		galaxy.writeFile();
		galaxy.closeFile();
	}
}
