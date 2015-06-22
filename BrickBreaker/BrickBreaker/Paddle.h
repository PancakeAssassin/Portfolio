#pragma once

#include "GameObject.h"

class Paddle: public GameObject
{
private:
	int lives;
	int score;
	
public:
	Paddle();
	void Destroy();
	
	void Init();
	void Update();
	void Render();

	void MoveLeft();
	void MoveRight();
	void ResetAnimation();

	int GetLives() {return lives;}
	int GetScore() {return score;}

	void LoseLife() {lives--;}
	void AddPoint() {score++;}

	void Collided(GameObject *object);
};