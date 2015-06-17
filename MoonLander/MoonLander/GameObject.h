#ifndef GAMEOBJECT_H
#define GAMEOBJECT_H

#include <SDL.h>
#include <SDL_main.h>
#include <SDL_image.h>
#include <string>
#include "Globals.h"
#include "Vector.h"

class GameObject
{
protected:
	SDL_Surface* image;
	Vector pos;
	Vector vel;
	int width, height;
	float maxVel;
	int type;
	int collisionType;
	bool alive;

public:
	GameObject();
	GameObject(SDL_Surface* surf);
	GameObject(SDL_Surface* surf, Vector pos, float maxVel, int objType, int collision, bool alive);
	GameObject(SDL_Surface* surf, float x, float y, float maxVel, int objType, int collision, bool alive);
	GameObject(std::string filename, Vector pos, float maxVel, int objType, int collision, bool alive);
	GameObject(std::string filename, float x, float y, float maxVel, int objType, int collision, bool alive);
	~GameObject();

	void SetPos(Vector& p) {pos= p;}
	void SetPosX(float x) {pos.SetX(x);}
	void SetPosY(float y) {pos.SetY(y);}
	Vector& GetPos() {return pos;}
	float GetPosX() {return pos.GetX();}
	float GetPosY() {return pos.GetY();}

	void SetVel(Vector& v) {vel= v;}
	void SetVelX(float x) {vel.SetX(x);}
	void SetVelY(float y) {vel.SetY(y);}
	Vector& GetVel() {return vel;}
	float GetVelX() {return vel.GetX();}
	float GetVelY() {return vel.GetY();}

	void SetWidth(int w) {width= w;}
	int GetWidth() {return width;}

	void SetHeight(int h) {height= h;}
	int GetHeight() {return height;}

	int GetType() {return type;}
	void SetType(int t) {type= t;}

	void setAlive(bool a)  {alive= a;}
	bool isAlive() {return alive;}

	void setCollisionType(int col) {collisionType= col;}

	void Animate();
	void Move(float dt);
	bool DrawSurface(SDL_Surface* dest);

	bool Collided(GameObject* obj);

	SDL_Surface* LOADImage(std::string filename);
};

#endif