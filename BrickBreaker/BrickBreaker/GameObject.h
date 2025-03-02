#pragma once

#include <iostream>
#include <allegro5\allegro.h>
#include <allegro5\allegro_primitives.h>
#include "Globals.h"

class GameObject
{
private:
	int ID;
	bool alive;
	bool collidable;

protected:
	float x;
	float y;

	float velX;
	float velY;
	
	int dirX;
	int dirY;

	int boundX;
	int boundY;

	int maxFrame;
	int curFrame;
	int frameCount;
	int frameDelay;
	int frameWidth;
	int frameHeight;
	int animationColumns;
	int animationDirection;

	ALLEGRO_BITMAP *image;

public:
	GameObject();
	virtual void Destroy();

	void Init(float x, float y, float velX, float velY, int dirX, int dirY, int boundX, int boundY);
	virtual void Update();
	virtual void Render();

	float GetX() {return x;}
	float GetY() {return y;}

	void SetX(int x) {GameObject::x = x;}
	void SetY(int y) {GameObject::y = y;}

	int GetBoundX() {return boundX;}
	int GetBoundY() {return boundY;}

	int GetFrameWidth() {return frameWidth;}
	int GetFrameHeight() {return frameHeight;}

	int GetID() {return ID;}
	void SetID(int ID) {GameObject::ID= ID;}

	bool GetAlive() {return alive;}
	void SetAlive(bool alive) {GameObject::alive= alive;}

	bool GetCollidable() {return collidable;}
	void SetCollidable(bool collidable) {GameObject::collidable= collidable;}

	bool CheckCollisions(GameObject *otherObject);
	virtual void Collided(GameObject *object);
	bool Collidable();
};