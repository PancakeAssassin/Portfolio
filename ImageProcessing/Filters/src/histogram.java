import java.io.File;
import java.io.IOException;

import jxl.Workbook;
import jxl.write.Number;
import jxl.write.WritableSheet;
import jxl.write.WritableWorkbook;
import jxl.write.WriteException;
import jxl.write.biff.RowsExceededException;


public class histogram 
{
	WritableWorkbook wkbk;
	
	
	public histogram(String name) throws IOException
	{
		String fileName= name + ".xls";
		wkbk= Workbook.createWorkbook(new File(fileName));
	}
	
	public WritableSheet createImageSheet(BWImage theImage, String sheetName, int sheetNum) throws RowsExceededException, WriteException
	{
		//create a sheet in the excel file
		WritableSheet sheet= wkbk.createSheet(sheetName, sheetNum);
		
		int[] img= theImage.findValueArray();
		
		//write the possible grey levels of a pixel
		//and the number of times each grey level appears
		for(int i= 0; i< img.length; i++)
		{
			Number num1= new Number(0, i, i);
			Number num2= new Number(1, i, img[i]);
			
			sheet.addCell(num1);
			sheet.addCell(num2);
		}
		
		return sheet;
	}
	
	
	//write to excel file
	public Boolean writeFile()
	{
		try 
		{
			
			wkbk.write();
		} catch (IOException e)
		{
			// TODO Auto-generated catch block
			e.printStackTrace();
			return false;
		}
		return true;
	}
	
	
	//close the excel file
	public Boolean closeFile()
	{
		try 
		{
			wkbk.close();
		} catch (WriteException | IOException e) 
		{
			// TODO Auto-generated catch block
			e.printStackTrace();
			return false;
		}
		
		return true;
	}
}
