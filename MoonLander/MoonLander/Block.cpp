#include "Block.h"

Block::Block()
{	
	srand(time(NULL));
	width= rand()%(100)+100;
	height= rand()%(100)+50;

	//GameObject(NULL, x, y, 0, BLOCK, COLLISION_DISTANCE, true);
	image= NULL;
	pos.SetX(rand()%(SCREEN_WIDTH - width/2) + width/2);
	pos.SetY(rand()%(SCREEN_HEIGHT - (50+height/2)) +  height/2 + 50);
	maxVel= 0;
	type= BLOCK;
	collisionType= COLLISION_DISTANCE;
	alive= true;
	col= createNewColor();
}

Block::Block(SDL_Surface* bl)
{
	srand(time(NULL));
	width= rand()%(100)+100;
	height= rand()%(100)+50;
	//GameObject(bl, x, y, 0, BLOCK, COLLISION_DISTANCE, true);
	image= bl;
	pos.SetX(rand()%(SCREEN_WIDTH));
	pos.SetY(rand()%(SCREEN_HEIGHT));
	maxVel= 0;
	type= BLOCK;
	collisionType= COLLISION_DISTANCE;
	alive= true;
	col= createNewColor();
}

Block::Block(std::string filename)
{
	GameObject(filename, 0, 0, 0, BLOCK, COLLISION_DISTANCE, true);
}

void Block::Animate()
{
}

void Block::DrawSurface(SDL_Surface* dest)
{
	SDL_Rect rect;
	rect.x= pos.GetX()-(width/2);
	rect.y= pos.GetY()-(height/2);
	rect.w= width;
	rect.h= height;
	SDL_FillRect(dest, &rect, SDL_MapRGB(dest->format, col.r, col.g, col.b));
}

SDL_Color Block::createNewColor()
{
	int r, g, b;
	do
	{
		r= rand() % 256;
		g= rand() % 256;
		b= rand() % 256;
	}while(r <125 && g<125 && b<125);

	SDL_Color theColor= {r, g, b};
	return theColor;
}