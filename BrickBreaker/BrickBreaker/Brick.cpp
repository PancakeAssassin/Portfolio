#include "Brick.h"

Brick::Brick(float x, float y, int pointValue, void(*ScorePoint)(void))
{

	SetID(BRICK);

	frameWidth= 80;
	frameHeight= 32;

	GameObject::Init(x+frameWidth/2, y+frameHeight/2, 0, 0, 0, 0, frameWidth, frameHeight);

	Brick::pointValue= pointValue;
	health= pointValue;
	currentColor= pointValue;


	Brick::ScorePoint= ScorePoint;
}

void Brick::Destroy()
{
}

void Brick::Update()
{
	//GameObject::Update();
	if(health<= 0)
	{
		ScorePoint();
		SetAlive(false);
	}
}

void Brick::Render()
{
	al_draw_filled_rectangle(x-frameWidth/2, y-frameHeight/2, x+frameWidth/2, y+frameHeight/2, al_map_rgb(0, 255, 0));
	al_draw_rectangle(x-frameWidth/2, y-frameHeight/2, x+frameWidth/2, y+frameHeight/2, al_map_rgb(0, 0, 0), 2);
	
}

void Brick::Collided(GameObject *object)
{
	if(object->GetID()== BALL)
		health--;
}