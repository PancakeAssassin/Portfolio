#HW3 Question 2 Chris Minda
#takes a system of two linear equations and solves for x and y

class LinearEquation:

   #the contructor is set up so
   # a user can enter the 3 terms in the first lineq (a,b,e)
   #then the the 3 terms of the second lineq (c,d,f)
   def __init__(self, a, b, e, c, d, f):
       self.__a= a
       self.__b= b
       self.__c= c
       self.__d= d
       self.__e= e
       self.__f= f

   def getA(self):
      return self.__a
    
   def getB(self):
      return self.__b

   def getC(self):
      return self.__c

   def getD(self):
      return self.__d

   def getE(self):
      return self.__e

   def getF(self):
      return self.__f

   def isSolvable(self):
      if (self.__a*self.__d) - (self.__b*self.__c) != 0:
         return True
      else:
         return False

   def getX(self):
      if not self.isSolvable():
         return None
      x= ((self.__e*self.__d)-(self.__b*self.__f))/((self.__a*self.__d)-(self.__b*self.__c))
      return x

   def getY(self):
      if  not self.isSolvable():
         return None
      y= ((self.__a*self.__f)-(self.__e*self.__c))/((self.__a*self.__d)-(self.__b*self.__c))
      return y

if __name__ == '__main__':
   #Eq1 simple solvable linear equation
   eq1= LinearEquation(1, 1, 3, 1, 2, 4)
   assert(eq1.getA() == 1)
   assert(eq1.getB() == 1)
   assert(eq1.getE() == 3)
   assert(eq1.getC() == 1)
   assert(eq1.getD() == 2)
   assert(eq1.getF() == 4)
   print("Eq1: ")
   print("", eq1.getA(), "x + ", eq1.getB(), "y = ", eq1.getE())
   print("", eq1.getC(), "x + ", eq1.getD(), "y = ", eq1.getF())
   assert(eq1.isSolvable()== True)
   print("Eq1 is solvable: " + str(eq1.isSolvable()))  
   assert(eq1.getX() == 2)
   print("Eq1's value for x is: ", eq1.getX())
   assert(eq1.getY() == 1)
   print("Eq1's value for y is: ", eq1.getY())

   #for formatting
   print()
   
   #Eq2 unsolvable
   eq2= LinearEquation(2, 2, 4, 3, 3, 6)
   assert(eq2.getA() == 2)
   assert(eq2.getB() == 2)
   assert(eq2.getE() == 4)
   assert(eq2.getC() == 3)
   assert(eq2.getD() == 3)
   assert(eq2.getF() == 6)
   print("Eq2: ")
   print("", eq2.getA(), "x + ", eq2.getB(), "y = ", eq2.getE())
   print("", eq2.getC(), "x + ", eq2.getD(), "y = ", eq2.getF())
   assert(eq2.isSolvable() == False)
   print("Eq2 is solvable: " + str(eq2.isSolvable()))
   assert(eq2.getX() == None)
   print("Eq2's value for x is: ", eq2.getX())
   assert(eq2.getY() == None)
   print("Eq2's value for y is: ", eq2.getY())
   print("All tests passed.")
