#include "Ship.h"

//CONSTRUCTORS
Ship::Ship()
{
	GameObject();
}

Ship::Ship(SDL_Surface* img, Vector pos)
{
	GameObject(img, pos, MAX_SHIP_VEL, SHIP, COLLISION_BOX, true);
}

Ship::Ship(SDL_Surface* img, float x, float y)
{
	GameObject(img, x, y, MAX_SHIP_VEL, SHIP, COLLISION_BOX, true);
}

Ship::Ship(std::string filename, Vector pos)
{
	//GameObject(filename, pos, MAX_SHIP_VEL, SHIP, COLLISION_BOX, true);
	image= LOADImage(filename);
	width= image->w;
	height= image->h;
	pos.Set(pos);
	vel= Vector(0.0f, 0.0f);
	maxVel= MAX_SHIP_VEL;
	type= SHIP;
	collisionType= COLLISION_BOX;
	alive= true;
	hasLanded= false;
	explosion= Mix_LoadWAV("explosion.wav");
	boostSound=  Mix_LoadWAV("booster.wav");
}

Ship::Ship(std::string filename, float x, float y)
{
	//GameObject(filename, x, y, MAX_SHIP_VEL, SHIP, COLLISION_BOX, true);
	image= LOADImage(filename);
	width= image->w;
	height= image->h;
	pos= Vector(x,y);
	vel= Vector(0.0f, 0.0f);
	maxVel= MAX_SHIP_VEL;
	type= SHIP;
	collisionType= COLLISION_BOX;
	alive= true;
	hasLanded= false;
	explosion= Mix_LoadWAV("explosion.wav");
	boostSound= Mix_LoadWAV("booster.wav");
}

Ship::~Ship()
{
	Mix_FreeChunk(explosion);
	Mix_FreeChunk(boostSound);
}

void Ship::Move(float dt)
{
	vel.SetY(vel.GetY() + .5*GRAVITY*pow(dt,2));
	if(hasLanded)
	{
		if(vel.GetX() > 0)
			vel.SetX(vel.GetX() - .5*friction*pow(dt,2));
		else if(vel.GetX() < 0)
			vel.SetX(vel.GetX() + .5*friction*pow(dt,2));
	}
	GameObject::Move(dt);
	if(pos.GetX() < -(image->w))
	{
		pos.SetX(SCREEN_WIDTH);
	}
	else if(pos.GetX() > SCREEN_WIDTH)
	{
		pos.SetX(-(image->w));
	}
	if(pos.GetY() < 0)
	{
		vel.SetY(0);
		pos.SetY(0);
	}
	else if(pos.GetY()+ GetHeight()/2 > SCREEN_HEIGHT)
	{
		if(vel.GetY() > SHIP_RAM_SPEED)
		{
			alive= false;
			Mix_PlayChannel(-1,explosion ,0);
		}
		pos.SetY(SCREEN_HEIGHT-GetHeight()/2);
		vel.SetY(0.0f);
	}
	if(vel.GetY() == 0.0f)
	{
		hasLanded= true;
	}
	else if(vel.GetY() > 0.5f || vel.GetY() < -0.5f)
	{
		hasLanded= false;
	}
}

void Ship::Animate()
{
}

void Ship::Boost(Vector v)
{
	if(v.GetX() != 0 || v.GetY() != 0)
	{
		Mix_PlayChannel(-1, boostSound, 0);
	}
	vel.SetX(vel.GetX() + v.GetX());
	vel.SetY(vel.GetY() + v.GetY());
}

bool Ship::DrawSurface(SDL_Surface* screen)
{
	if(alive)
	{
		SDL_Rect rect;
		rect.x= pos.GetX()-GetWidth()/2;
		rect.y= pos.GetY()-GetHeight()/2;
	
		if(screen == NULL || image == NULL)
		{
			return false;
		}

		SDL_BlitSurface(image, NULL, screen, &rect);
	}
	return true;
}

void Ship::OnCollision(GameObject* obj)
{
	if(obj->GetType() == BLOCK)
	{
		if(vel.GetY() > 0.0f && (pos.GetY() < obj->GetPosY() - (obj->GetHeight()/2)+.001))
		{
			if(vel.GetY() > SHIP_RAM_SPEED)
			{
				alive= false;
				Mix_PlayChannel(-1, explosion, 0);
			}
			else
			{
				float ny= obj->GetPosY()-(obj->GetHeight()/2)-(GetHeight()/2);
				SetPosY(ny);
				SetVelY(0.0f);
				hasLanded= true;
			}
		}
		else if(vel.GetY() < 0.0f && (pos.GetY() > obj->GetPosY() + (obj->GetHeight()/2)-.001))
		{
			if(vel.GetY() < -SHIP_RAM_SPEED)
			{
				alive= false;
				Mix_PlayChannel(-1, explosion, 0);
			}
			else
			{
				float ny= obj->GetPosY() + (obj->GetHeight()/2)+(GetHeight()/2);
				SetPosY(ny);
				SetVelY(0.0f);
			}
		}

		if(vel.GetX() > 0.0f && (pos.GetX() < obj->GetPosX() - (obj->GetWidth()/2)+.001))
		{
			
			if(vel.GetX() > SHIP_RAM_SPEED)
			{
				alive= false;
				Mix_PlayChannel(-1, explosion, 0);
			}
			else
			{
				float nx= obj->GetPosX() - (obj->GetWidth()/2)-(GetWidth()/2);
				SetPosX(nx);
				SetVelX(0.0f);
			}
		}
		else if(vel.GetX() < 0.0f && (pos.GetX() > obj->GetPosX() + (obj->GetWidth()/2)-.001))
		{
			
			if(vel.GetX() < -SHIP_RAM_SPEED)
			{
				alive= false;
				Mix_PlayChannel(-1, explosion, 0);
			}
			else
			{
				float nx= obj->GetPosX() + (obj->GetWidth()/2)+(GetWidth()/2);
				SetPosX(nx);
				SetVelX(0.0f);
			}
		}
	}
}