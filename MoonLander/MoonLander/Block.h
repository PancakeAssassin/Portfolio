#ifndef BLOCK_H
#define BLOCK_H
#include "GameObject.h"
#include <time.h>

class Block: public GameObject
{

private:
	SDL_Color col;

public:
	Block();
	Block(SDL_Surface* bl);
	Block(std::string filename);

	void Animate();
	void DrawSurface(SDL_Surface* dest);
	SDL_Color createNewColor();
};

#endif