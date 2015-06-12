//
//Chris Minda
//Started: 9/14/12 Due: 9/27/12
#include <fstream>
#include <iostream>
#include <iomanip>
#include <string>
#include <list>
#include <vector>

using namespace std;



//global vars for opening and closing delimiters
char delopen;
char delclose;

//constant for format width of table columns
const int FORMATWIDTH= 25;

vector<list<string>> getAttributesList(ifstream& in_file);
vector<list<string>> getRelations(ifstream& in_file, string dbName);
void addAttributes(ifstream& in_file, string relName, list<string>& relation);
string extractTag(ifstream& in_file);
string extractValue(ifstream& in_file);
void dismissComment(ifstream& in_file);
void  writeTableToFile(ifstream& in_file, ofstream& out_file, vector<list<string>> attr);
void getEntity(ifstream& in_file, list<string> attr, vector<string>& eAttr, string tag, int size);

int main(int argc, char **argv)
{
	//load the XML file
	ifstream in_file;
	in_file.open("CSIT430_a1_SP2012.txt");
	
	delopen= '<';
	delclose= '>';

	vector<list<string>> attributes= getAttributesList(in_file);

	//load the file to print to
	ofstream out_file;
	out_file.open("Minda_C_a1A.txt");

	writeTableToFile(in_file, out_file, attributes);
	
	int a;
	cin>>a;

	in_file.close();
	out_file.close();
	return 0;
}

//scans through input file checking for entities and makes an attribute list for the entity
vector<list<string>> getAttributesList(ifstream& in_file)
{
	//open file to read from

	//create vector of lists of strings 
	//head of list will hold relation name, nodes following will hold the attributes
	vector<list<string>> attr;
	string db;
	if(in_file == NULL)
	{
		return attr;
	}

	char ch;
	cout<<"file has been opened";
	while(!in_file.eof())
	{
		in_file.get(ch);
		cout<<"reading through file"<<endl;
		if(ch==delopen)
		{
			cout<<"tag opener "<<endl;
			db= extractTag(in_file);
			//if db != "" then it is the db name
			//read through the file to get tags for relations and attributes
			if(db !="")
				attr= getRelations(in_file, db);			
			in_file.get(ch);
		}

	}
	return attr;

}

//returns the vector of the different relations specified in the file
vector<list<string>> getRelations(ifstream& in_file, string dbName)
{
	string tag= "";
	char ch;
	int i;
	vector<list<string>> attr;
	list<string> newRel;
	bool relCheck= false;
	while(tag != '/' + dbName)
	{
		in_file.get(ch);
		cout<<"reading through "<< dbName<< endl;

		if(ch== delopen)
		{
			cout<<"tag opener ";
			tag= extractTag(in_file);
			cout<< tag<<endl;
			//if tag != "" then it is a relation name
			//read through vector to check if it has already been 
			//placed in the vector if not, place it in the vector at the head of the list
			for(i= 0; i<attr.size(); i++)
			{
				if(attr[i].front() == tag)
				{
					addAttributes(in_file, tag, attr[i]);
					relCheck= true;
				}
			}
			//if the relation wasn't found in the vector then add the relation name to the vector
			if(relCheck== false && tag != '/'+ dbName)
			{
				cout<<"adding "<< tag<<"to the relation vector"<<endl;
				newRel.push_front(tag);	
				attr.push_back(newRel);
				addAttributes(in_file, tag, attr.back());
				newRel.clear();
			}
			relCheck= false;
		}
	}
	return attr;
}

//adds attributes to the relation list if they are not already present
void addAttributes(ifstream& in_file, string relName, list<string>& relation)
{
	cout<<"Add attributes entered"<<endl;
	string attribute="";
	char ch;
	bool attrIsThere= false;
	int a;

	int i;
	while(attribute != ('/'+relName))
	{
		in_file.get(ch);
		cout<<"reading through "<< relName<< endl;
		if(ch == delopen)
		{
			attribute= extractTag(in_file);
			cout<<attribute<<" tag found"<<endl;
		
			for (list<string>::iterator it=relation.begin(); it!=relation.end(); it++)
			{
				if(*it == attribute || '/' + *it == attribute)
					attrIsThere= true;
			}
			if(!attrIsThere)
			{
				//adding new item to the current list
				cout<<"adding "<< attribute<< " to the list"<<endl;
				cin>>a;
				relation.push_back(attribute);
			}
		}
		attrIsThere= false; 
	}
}

//extracts the tagname and returns the string value
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

//extracts a value for a tag and returns it
string extractValue(ifstream& in_file)
{
	char ch;
	in_file.get(ch);
	string value="";
	while(ch != '<')
	{
		value+=ch;
		in_file.get(ch);
	}

	return value;
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

//prints table for entities
void writeTableToFile(ifstream& in_file, ofstream& out_file, vector<list<string>> attr)
{
	//this was used to make sure that the attributes were being properly loaded into their lists
	/*int i;
	for(i=0; i<attr.size(); i++)
	{
		 for (list<string>::iterator it=attr[i].begin(); it!=attr[i].end(); ++it)
		{
			cout<<*it<<endl;
		}
	}*/
	int i;
	vector<string> entityAttribute;
	string tag= "";
	string extracted= "";
	char ch;
	for(i= 0; i<attr.size(); i++)
	{

		//reset the inputfile pointer to beginning
		in_file.clear();
		in_file.seekg(0, ios::beg);
		
		//one less because relation name is first in list
		int counter= 0;
		for(list<string>::iterator it= attr[i].begin(); it!=attr[i].end(); it++)
		{
			//relation title
			if(counter == 0)
			{
				out_file<<"Relation: "<< *it<< endl;
			}
			else
			{
				out_file<<left<< setw(FORMATWIDTH)<<*it;
			}
			counter++;
		}
		out_file<<endl;
		tag= attr[i].front();
		entityAttribute.resize(counter);

		while(!in_file.eof())
		{
			extracted="";
			in_file.get(ch);
			cout<<"reading through file"<<endl;
			for(int k= 0; k<entityAttribute.size(); k++)
			{
				entityAttribute[k]= "";
			}
			if(ch==delopen)
			{
				
				extracted= extractTag(in_file);
				//if extracted == tag then it is one of the records for the table
				//read through the file to get the attributes for this relation
				if(extracted == tag)
				{
					cout<<"tag opener to read in att values for output file"<<endl;
					getEntity(in_file, attr[i], entityAttribute, tag, counter);	

					for(int j= 0; j<entityAttribute.size(); j++)
					{
						out_file<<left<<setw(FORMATWIDTH)<< entityAttribute[j];
					}
					out_file<<endl;
				}
				in_file.get(ch);

			}
			
		}
	}
}

void getEntity(ifstream& in_file, list<string> attr, vector<string>& eAttr, string tag, int size)
{
	string curTag= "";
	char ch;
	int counter;
	string attribute= "";
	while(!in_file.eof() && curTag != '/' + tag)
	{
		in_file.get(ch);
		counter= -1;
		attribute= "";
		if(ch== delopen)
		{
			curTag= extractTag(in_file);
			for(list<string>::iterator it= attr.begin(); it!=attr.end(); it++)
			{	
				
				if(curTag == *it)
				{
					in_file.get(ch);
					while(ch != delopen)
					{
						attribute+= ch;
						in_file.get(ch);
					}
					cout<<"Attribute value: "<< attribute;
					eAttr[counter]= attribute;
					break;
				}
				counter++;
			}
		}
	}
}