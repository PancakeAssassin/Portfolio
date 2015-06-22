#include "Ball.h"

Ball::Ball(void(*SubtractLife)(void))
{
	GameObject::Init(0, 0, CURSPEED, CURSPEED, 0, 1, 5, 5);

	maxSpeed= MAXSPEED;
	curSpeed= CURSPEED;

	speedIncDelay= 5;
	counter= 0;
	frameWidth= 10;
	frameHeight= 10;

	Ball::SubtractLife= SubtractLife;

	SetID(BALL);
}

void Ball::Destroy()
{
	GameObject::Destroy();
}

void Ball::Reset()
{
	GameObject::Init(WIDTH/2, HEIGHT- 250, 0, CURSPEED, 1, 1, 10, 10);
	SetID(BALL);
}

void Ball::Update()
{
	GameObject::Update();

	if(x<0)
	{
		x= 0;
		dirX*= -1;
	}
	else if (x > WIDTH)
	{
		x= WIDTH;
		dirX*= -1;
	}
	if(y<0)
	{
		y= 0;
		velY*=-1;
	}
	else if(y>HEIGHT+10)
	{
		Reset();
		SubtractLife();
	}
	

}

void Ball::Render()
{
	GameObject::Render();
	al_draw_filled_circle(x, y, frameWidth, al_map_rgb(135, 206, 250));
	al_draw_circle(x, y, frameWidth, al_map_rgb(0, 0, 0), 1);
}

void Ball::Collided(GameObject *object)
{
	int pos; 
	float hitpercent;
	//std::cout<<"BALL collision called"<<std::endl;
	if(object->GetID() == BRICK )
	{
		std::cout<<"BALL collides with BRICK"<<std::endl;
		velY *= -1;
		pos= x - object->GetX();
		hitpercent= ((float)pos/ (frameWidth - object->GetFrameWidth()) - .5);
		dirX= 1;
		velX= CURSPEED * hitpercent;
	}
	else if(object->GetID() == PLAYER)
	{
		std::cout<<"BALL collides with PADDLE. current velocity: "<< velY<<std::endl;
		velY*= -1;
		//needs to be changed when the collided function gets updated
		pos= x - object->GetX();
		hitpercent= ((float)pos/ (frameWidth - object->GetFrameWidth()) - .5);
		dirX= 1;
		velX= CURSPEED * hitpercent;
	}
		
}