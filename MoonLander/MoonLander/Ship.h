#ifndef SHIP_H
#define SHIP_H

#include <SDL_mixer.h>
#include "GameObject.h"


class Ship: public GameObject
{
private:
	bool hasLanded;
	Mix_Chunk* explosion;
	Mix_Chunk* boostSound;
public:
	Ship();
	Ship(SDL_Surface* img, Vector pos);
	Ship(SDL_Surface* img, float x, float y);
	Ship(std::string filename, Vector pos);
	Ship(std::string filename, float x, float y);

	~Ship();

	void Move(float dt);
	void Animate();
	void Boost(Vector v);
	bool Landed() {return hasLanded;}

	bool DrawSurface(SDL_Surface*  screen);

	void OnCollision(GameObject* obj);
};

#endif