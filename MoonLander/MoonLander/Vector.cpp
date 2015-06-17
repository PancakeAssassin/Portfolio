#include "Vector.h"

//Constructors
Vector::Vector()
{
	x= 0;
	y= 0;
}

/*Vector::Vector(int X, int Y)
{
	x= (float)X;
	y= (float)Y;
}*/

Vector::Vector(float X, float Y)
{
	x= X;
	y= Y;
}

//OVERLOADING OPERATORS
//assignment operator
Vector& Vector::operator=(const Vector& v)
{
	x= v.x;
	y= v.y;

	return *this;
}

//Vector addition
Vector& Vector::operator+(const Vector& v)
{
	Vector sum;
	sum.x= x +v.x;
	sum.y= y +v.y;

	return sum;
}

//Vector subtraction
Vector& Vector::operator-(const Vector& v)
{
	Vector diff;
	diff.x= x- v.x;
	diff.y= y- v.y;

	return diff;
}

//Scalar multiplication
Vector& Vector::operator*(float scalar)
{
	Vector prod;
	prod.x= x*scalar;
	prod.y= y*scalar;

	return prod;
}
 
Vector& Vector::operator*(const Vector& v)
{
	Vector prod;
	prod.x= x*v.x;
	prod.y= y*v.y;

	return prod;
}

//Reduction
Vector& Vector::operator/(float reduce)
{
	if(reduce == 0.0)
		return Vector(0, 0);
	Vector quotient;
	quotient.x= x/reduce;
	quotient.y= y/reduce;

	return quotient;
}

Vector& Vector::operator/(const Vector& v)
{
	Vector quo;
	if(v.x == 0)
		quo.x= 0;
	else
		quo.x= x/ v.x;
	if(v.y == 0)
		quo.y= 0;
	else
		quo.y= y/v.y;

	return quo;
}

//EQUALS operator
bool Vector::operator==(const Vector& v)
{
	return ((x < v.x + 0.00001) && (x > v.x - 0.00001)  &&
			(y < v.y + 0.00001) && (y > v.y - 0.00001));
}

//NOT EQUALS operator
bool Vector::operator!=(const Vector& v)
{
	return !(*this==v);
}

//returns the length of the vector
double Vector::length()
{
	return sqrt((x*x) + (y*y));
}

//finds the distance between two vectors
double Vector::distance(const Vector& v)
{
	return sqrt(((x-v.x)*(x-v.x))+((y-v.y)*(y-v.y)));
}

//calculates the dot Product between two vectors
double Vector::dotProduct(const Vector& v)
{
	return x*v.x + y*v.y;
}

//finds the normal vector
Vector& Vector::Normalize()
{
	double l= length();
	if(l == 0)
		return Vector(0, 0);
	Vector normal;
	normal.x= x/l;
	normal.y= y/l;

	return normal;
}