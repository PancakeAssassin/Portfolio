//Vector class
#ifndef VECTOR_H
#define VECTOR_H
#include <math.h>

class Vector
{
private:
	float x,y;

public:
	Vector();
	//Vector(int X, int Y);
	Vector(float X, float Y);

	void SetX(float X) {x= X;}
	float GetX() {return x;}
	void SetY(float Y) {y= Y;}
	float GetY() {return y;}

	void Set(const Vector& v) {x= v.x; y= v.y;}

	Vector& operator=(const Vector &v);
	Vector& operator+(const Vector &v);
	Vector& operator-(const Vector &v);
	Vector& operator*(float scalar);
	Vector& operator*(const Vector &v);
	Vector& operator/(float reduce);
	Vector& operator/(const Vector &v);
	bool operator==(const Vector &v);
	bool operator!=(const Vector &v);

	double length();
	double distance(const Vector &v);
	double dotProduct(const Vector &v);

	Vector& Normalize();
};

#endif