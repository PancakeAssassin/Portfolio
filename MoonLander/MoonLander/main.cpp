#include <SDL.h>
#include <SDL_main.h>
#include <SDL_image.h>
#include <SDL_ttf.h>
#include <SDL_mixer.h>
#include <string>
#include <time.h>
#include "GameObject.h"
#include "Background.h"
#include "Block.h"
#include "Ship.h"
#include "Vector.h"
#include "Timer.h"
#include "Globals.h"

using namespace std;

bool init();
void clean_up();
bool load_files();
void stateChange(int& current, int newState);
void readInput();
void handleKeyboardInput();
void DisplayDetails();
bool checkWinner();

TTF_Font* font= NULL;
TTF_Font* result= NULL;
SDL_Surface* details= NULL;
SDL_Surface* screen= NULL;

int state= 0;
SDL_Event e;

bool g_exit;
bool isWinner;
Ship* spaceShip;
Block* block1;
Timer fps;

Mix_Music* music= NULL;


int main(int argc, char* args[])
{
	if(!init())
	{
		return 1;
	}
	if(!load_files())
	{
		return 1;
	}
	g_exit= false;
	isWinner= false;
	stateChange(state, GAME);
	while(!g_exit)
	{
		fps.start();
		SDL_FillRect(screen, &screen->clip_rect, SDL_MapRGB(screen->format, 0x00, 0x00, 0x00));
		while(SDL_PollEvent(&e))
		{
			readInput();
		}
		handleKeyboardInput();


		spaceShip->Move(.01);
		if(spaceShip->Collided(block1))
			spaceShip->OnCollision(block1);
		spaceShip->DrawSurface(screen);
		block1->DrawSurface(screen);
		isWinner= checkWinner();
		DisplayDetails();
		SDL_Flip(screen);

	}

	clean_up();
	return 0;
}

bool init()
{
	//initialize SDL subsystems
	if(SDL_Init(SDL_INIT_EVERYTHING)==-1)
	{
		return false;
	}
	//setup screen
	screen= SDL_SetVideoMode(SCREEN_WIDTH, SCREEN_HEIGHT, 32, SDL_SWSURFACE);
	
	if(screen == NULL)
	{
		return false;
	}

	//initialize sdl_ttf
	if(TTF_Init() == -1)
	{
		return false;
	}

	if(Mix_OpenAudio(22050, MIX_DEFAULT_FORMAT, 2, 4096)==-1)
	{
		return false;
	}

	//set the window caption
	SDL_WM_SetCaption("Moon Lander", NULL);

	//everything has initialized fine
	return true;
}

bool load_files()
{
	font= TTF_OpenFont("AGENCYR.ttf", 30);
	
	if(font == NULL)
	{
		return false;
	}

	result= TTF_OpenFont("AGENCYB.ttf", 35);
	if(result == NULL)
	{
		return false;
	}

	music= Mix_LoadMUS("SpaceShipClip.wav");
	if(music == NULL)
	{
		return false;
	}
	
	return true;
}

void clean_up()
{
	delete block1;
	delete spaceShip;
	Mix_FreeMusic(music);
	SDL_FreeSurface(screen);
	TTF_CloseFont(font);
	TTF_CloseFont(result);
	Mix_CloseAudio();
	TTF_Quit();
	SDL_Quit();
}

void stateChange(int& current, int newState)
{
	//final actions before stateChange
	if(current== GAME)
	{
		delete block1;
		delete spaceShip;
		Mix_HaltMusic();
	}
	//change states
	current= newState;
	if(current== GAME)
	{
		spaceShip=  new Ship("ship.png", 320.0f, 30.0f);
		block1= new Block();
		Mix_PlayMusic(music,-1);
	}

	//first actions after stateChange
}

//input functions
void readInput()
{
	if(e.type == SDL_QUIT)
	{
		g_exit= true;
	}

	if(e.type == SDL_QUIT)
	{
		g_exit= true;
	}
}

void handleKeyboardInput()
{
	Uint8* keys= SDL_GetKeyState(NULL);

	if(keys[SDLK_ESCAPE])
	{
		g_exit= true;
	}
	if(keys[SDLK_UP])
	{
		spaceShip->Boost(Vector(0.0f,-.01f));
	}
	if(keys[SDLK_DOWN])
	{
		spaceShip->Boost(Vector(0.0f, 0.01f));
	}
	if(keys[SDLK_RIGHT])
	{
		spaceShip->Boost(Vector(0.01f, 0.0f));
	}
	if(keys[SDLK_LEFT])
	{
		spaceShip->Boost(Vector(-0.01f, 0.0f));
	}
	if(keys[SDLK_r])
	{
		stateChange(state, GAME);
	}
}


void DisplayDetails()
{
	SDL_Rect offset;
	SDL_Color col= {255, 255, 255};
	string det;

	det= "Pos: " + std::to_string((int)spaceShip->GetPosX()) + ", " + std::to_string((int)spaceShip->GetPosY());
	details= TTF_RenderText_Solid(font, det.c_str() , col);
	offset.x= 10;
	offset.y= 10;
	SDL_BlitSurface(details, NULL, screen, &offset);


	det= "Vel: "+ std::to_string((int)spaceShip->GetVelX()) +", "+ std::to_string((int)spaceShip->GetVelY());
	details= TTF_RenderText_Solid(font, det.c_str() , col);
	offset.y= 50;
	SDL_BlitSurface(details, NULL, screen, &offset);

	if(spaceShip->isAlive() == false)
	{
		det= "Kaboom! The space ship did not land safely.";
		SDL_Color red= {255, 0, 0};
		details= TTF_RenderText_Solid(result, det.c_str(),  red);
		offset.x= SCREEN_WIDTH/2;
		offset.y= SCREEN_HEIGHT/2;
		SDL_BlitSurface(details, NULL, screen, &offset);

		det = "Press 'R' to play another level.";
		details = TTF_RenderText_Solid(result, det.c_str(), red);
		offset.x = SCREEN_WIDTH / 2;
		offset.y = SCREEN_HEIGHT / 2 + 50;
		SDL_BlitSurface(details, NULL, screen, &offset);
	}
	else if(isWinner)
	{
		SDL_Color yel= {255, 0, 255};
		det = "Congratulations! You have landed the ship successfully!";
		details= TTF_RenderText_Solid(result, det.c_str(),  yel);
		offset.x= SCREEN_WIDTH/2-225;
		offset.y= SCREEN_HEIGHT/2;
		SDL_BlitSurface(details, NULL, screen, &offset);

		det = "Press 'R' to play another level.";
		details = TTF_RenderText_Solid(result, det.c_str(), yel);
		offset.x = SCREEN_WIDTH / 2;
		offset.y = SCREEN_HEIGHT / 2 + 50;
		SDL_BlitSurface(details, NULL, screen, &offset);
	}
	
}

bool checkWinner()
{
	return (spaceShip->Landed() &&
			(spaceShip->GetPosY() <  block1->GetPosY()) &&
			(spaceShip->GetPosX() > (block1->GetPosX() - (block1->GetWidth()/2))) &&
			(spaceShip->GetPosX() < (block1->GetPosX() + (block1->GetWidth()/2))) &&
			(spaceShip->GetVelX() < 0.1) && (spaceShip->GetVelX()>-.01));
}