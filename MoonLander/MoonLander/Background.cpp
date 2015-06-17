#include "Background.h"

Background::Background()
{
	GameObject();
}

Background::Background(SDL_Surface* bg)
{
	GameObject(bg, 0, 0, 0, BACKGROUND, COLLISION_NONE, true);
}

Background::Background(std::string filename)
{
	GameObject(filename, 0, 0, 0, BACKGROUND, COLLISION_NONE, true);
}

void Background::Animate()
{
}