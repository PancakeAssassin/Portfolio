#include "Paddle.h"

Paddle::Paddle()
{
}

void Paddle::Destroy()
{
	GameObject::Destroy();
}

void Paddle::Init()
{
	GameObject::Init(WIDTH/ 2, HEIGHT - 25, 6, 0, 0, 0, 32, 0);

	SetID(PLAYER);
	SetAlive(true);

	lives= 3;
	score= 0;

	maxFrame= 0;
	curFrame= 0;
	frameWidth= 64;
	frameHeight= 25;
	animationColumns= 0;
	animationDirection= 0;

	//if(image!= NULL)
		//Paddle::image= image;
}

void Paddle::Update()
{
	GameObject::Update();

	if(x<0)
		x= 0;
	else if(x >WIDTH - frameWidth)
		x= WIDTH- frameWidth;
}

void Paddle::Render()
{
	GameObject::Render();
	al_draw_filled_rectangle(x-frameWidth/2, y, x+frameWidth/2, y+frameHeight, al_map_rgb(255, 255, 255));
	al_draw_rectangle(x-frameWidth/2, y, x+frameWidth/2, y+frameHeight, al_map_rgb(0, 0, 0), 2);
	
}

void Paddle::MoveLeft()
{
	dirX= -1;
}

void Paddle::MoveRight()
{
	dirX= 1;
}

void Paddle::ResetAnimation()
{
	dirX= 0;
}

void Paddle::Collided(GameObject *object)
{
	if(object->GetID() == BALL)
	{
		std::cout<< "Collision! PADDLE with BALL"<<std::endl;
	}
}