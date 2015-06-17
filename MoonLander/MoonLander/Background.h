#ifndef BACKGROUND_H
#define BACKGROUND_H

#include "GameObject.h"

class Background: public GameObject
{
public:
	Background();
	Background(SDL_Surface* bg);
	Background(std::string filename);

	void Animate();
};
#endif