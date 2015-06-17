#include "GameObject.h"

GameObject::GameObject()
{
	image= NULL;
	pos= Vector(0, 0);
	vel= Vector(0, 0);
	maxVel= 0;
	type= 0;
	collisionType= 0;
	alive= false;
}

GameObject::GameObject(SDL_Surface* surf)
{
	image= surf;
	pos= Vector(0, 0);
	vel= Vector(0, 0);
	maxVel= 0;
	type= 0;
	collisionType= 0;
	alive= false;
}

GameObject::GameObject(SDL_Surface* surf, Vector p, float maxV= 0, int objType= 0, int collision= 0, bool a=false)
{
	image= surf;
	width= image->w;
	height= image->h;
	pos= p;
	vel= Vector(0, 0);
	maxVel= maxV;
	type= objType;
	collisionType= collision;
	alive= a;
}

GameObject::GameObject(SDL_Surface* surf, float x, float y, float maxV=0, int objType=0, int collision=0, bool a=false)
{
	image= surf;
	width= image->w;
	height= image->h;
	pos= Vector(x, y);
	vel= Vector(0, 0);
	maxVel= maxV;
	type= objType;
	collisionType= collision;
	alive= a;
}

GameObject::GameObject(std::string filename, Vector p, float maxV=0, int objType= 0, int collision= 0, bool a=false)
{
	image= LOADImage(filename);
	width= image->w;
	height= image->h;
	pos= p;
	vel= Vector(0, 0);
	maxVel= maxV;
	type= objType;
	collisionType= collision;
	alive= a;
}

GameObject::GameObject(std::string filename, float x, float y, float maxV=0, int objType= 0, int collision= 0, bool a=false)
{
	image= LOADImage(filename);
	width= image->w;
	height= image->h;
	pos= Vector(x,y);
	vel= Vector(0, 0);
	maxVel= maxV;
	type= objType;
	collisionType= collision;
	alive= a;
}

GameObject::~GameObject()
{
	SDL_FreeSurface(image);
}

void GameObject::Move(float dt)
{
	if (vel.length() > maxVel)
	{
		Vector newVel= vel.Normalize();
		vel.SetX(newVel.GetX() * maxVel);
		vel.SetY(newVel.GetY() * maxVel);
	}
	pos.SetX(pos.GetX()+ vel.GetX()*dt);
	pos.SetY(pos.GetY()+ vel.GetY()*dt);
}

bool GameObject::DrawSurface(SDL_Surface* dest)
{
	SDL_Rect rect;
	rect.x= pos.GetX()-width/2;
	rect.y= pos.GetY()-height/2;
	
	if(dest == NULL || image == NULL)
	{
		return false;
	}

	SDL_BlitSurface(image, NULL, dest, &rect);

	return true;
}

bool GameObject::Collided(GameObject* obj)
{
	if(collisionType == COLLISION_NONE)
	{
		return false;
	}
	else if(collisionType == COLLISION_BOX)
	{
		return (((GetPosX()+(width/2))>(obj->GetPosX()-(obj->width/2))) &&
				((GetPosX()-(width/2))<(obj->GetPosX()+(obj->width/2))) &&
				((GetPosY()+(height/2))>(obj->GetPosY()-(obj->height/2))) &&
				((GetPosY()-(height/2))<(obj->GetPosY()+(obj->height/2))));
	
	}
	else if(collisionType == COLLISION_DISTANCE)
	{
		int radius1, radius2;
		if(width > height)
			radius1= width/2;
		else
			radius1= height/2;
		if(obj->width >obj->height)
			radius2= obj->width/2;
		else
			radius2= obj->height/2;

		return (radius1 +radius2) > 
			sqrt((GetPosX()-obj->GetPosX())*(GetPosX()-obj->GetPosX()) 
			+ (GetPosY()-obj->GetPosY())*(GetPosY()-obj->GetPosY()));
	}

	return false;
}

SDL_Surface* GameObject::LOADImage(std::string filename)
{
	SDL_Surface* temp= NULL;
	SDL_Surface* optimized= NULL;

	temp= IMG_Load(filename.c_str());
	if(temp!= NULL)
	{
		optimized= SDL_DisplayFormat(temp);
		SDL_FreeSurface(temp);

		if(optimized != NULL)
		{
			Uint32 colorkey= SDL_MapRGB(optimized->format, 0xFF, 0, 0xFF);
			SDL_SetColorKey(optimized, SDL_SRCCOLORKEY, colorkey);
		}
	}

	return optimized;
}