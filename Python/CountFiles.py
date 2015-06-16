#finds and counts all files in a specified directory 
import os

def getNumFiles(path):
    size= 0
    if not os.path.isfile(path):
        lst= os.listdir(path)
        for sub in lst:
            size+= getNumFiles(path + "\\" + sub)
    else:
        size+= 1
    return size


if __name__ == '__main__':
    path= input("Enter a directory: ").strip()
    try:
        print("The number of files is ", getNumFiles(path))
    except:
        print("Directory does not exist")
