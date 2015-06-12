//
//Chris Minda
//Started: 9/14/12 Due: 9/27/12
#include <fstream>
#include <iostream>
#include <iomanip>
#include <string>
#include <sstream>
#include <direct.h>

using namespace std;



//global vars for opening and closing delimiters
char delopen;
char delclose;

//constant for format width of table columns
const int FORMATWIDTH= 25;

void recordsToFile(ifstream& in_file);
void readWriteEntities(ifstream& in_file, string db);
void writeToFile(ifstream& in_file, string tag, int fileNum);
bool endOfRecord(string line, string tag);
string extractTag(string line);
string extractTag(ifstream& in_file);
string extractValue(ifstream& in_file);
void dismissComment(ifstream& in_file);


int main(int argc, char **argv)
{
	//load the XML file
	ifstream in_file;
	in_file.open("CSIT430_a1_SP2012.txt");
	
	delopen= '<';
	delclose= '>';

	recordsToFile(in_file);

	in_file.close();
	return 0;
}

//scans through input file checking for entities and makes an attribute list for the entity
void recordsToFile(ifstream& in_file)
{
	//open file to read from

	//create vector of lists of strings 
	//head of list will hold relation name, nodes following will hold the attributes
	string db;
	if(in_file == NULL)
	{
		return;
	}

	char ch;
	while(!in_file.eof())
	{
		in_file.get(ch);
		if(ch==delopen)
		{
			db= extractTag(in_file);
			//if db != "" then it is the db name
			//read through the file to get tags for relations and attributes
			if(db !="")
				readWriteEntities(in_file, db);			
		}

	}
}

//returns the vector of the different relations specified in the file
void readWriteEntities(ifstream& in_file, string dbName)
{
	string tag= "";
	bool endTag= false;
	string line= "";
	string num= "";
	char ch;
	int i;
	bool relCheck= false;
	//ostringstream convert;

	ofstream out_file;
	string dir= "Records";
	string the_File= "Minda_C_a1B";
	mkdir(dir.c_str());
	int count= 1;
	while(tag != '/' + dbName && !in_file.eof())
	{
		line="";
		tag="";
		getline(in_file, line);
		for(i= 0; i<line.size(); i++)
		{
			if(line[i] == delopen)
			{
				tag= extractTag(line.substr(i));
				break;
			}
		}
		if(tag != '/'+dbName && tag != "")
		{
			num= "";
			endTag=false;
			ostringstream convert;
			convert<<count;
			num= convert.str();
			out_file.open((dir+"/"+the_File+num+".txt").c_str());
			if(!out_file.is_open())
				cout<<dir+"/"+the_File+num+".txt"<< " did not open. File writing failed";
			out_file<<line<<endl;
			while(!endTag)
			{
				line="";
				getline(in_file, line);
				endTag=endOfRecord(line, tag);
				out_file<<line<<endl;
			}
			out_file.close();
			count++;
			convert.erase_event;
		}
	}
		
}


bool endOfRecord(string line, string tag)
{
	string newTag= "";
	for(int i= 0; i<line.size(); i++)
	{
		newTag="";
		if(line[i] == delopen)
		{
			newTag=extractTag(line.substr(i));
			if(newTag == '/' + tag)
				return true;
		}
	}
	return false;
}

//extracts the tagname from a line and returns the string value
//if it is a comment the function will return an empty string
string extractTag(string line)
{
	char ch;
	string tag= "";
	bool writeTag= false;
	for(int i= 0; i< line.size(); i++)
	{
		ch= line[i];
		if(ch == delopen)
		{
			writeTag= true;
			continue;
		}
		if(ch == delclose)
			return tag;
		if(writeTag)
			tag+= ch;
	}
	return tag;
}

//extracts the tagnamefrom the input file and returns the string value
//if it is a comment the function will return an empty string
string extractTag(ifstream& in_file)
{
	char ch;
	in_file.get(ch);
	string tag="";
	while(ch != '>' || in_file.eof())
	{
		tag+= ch;

		if(tag=="!--")
		{
			dismissComment(in_file);
			return "";
		}
		in_file.get(ch);
	}

	return tag;
}

//reads through the input file until a comment end is reached
void dismissComment(ifstream& in_file)
{
	string commentEnd="-->";
	string isThisTheEnd="";
	char ch;
	in_file.get(ch);
	//will loop until a commentEnd is reached
	while(1)
	{
		if(ch == '-')
		{
			//reads the three characters and checks if this is the commentEnd
			isThisTheEnd+= ch;
			in_file.get(ch);
			isThisTheEnd+= ch;
			in_file.get(ch);
			isThisTheEnd+=ch;
			//if this is the end of the comment return true and continue reading through the file
			if(commentEnd == isThisTheEnd)
				return;
			//steps back two steps so when the next character is read it is what would have been read next if the condition wasnt true
			in_file.unget();
			in_file.unget();
		}
		in_file.get(ch);
	}
	
}

