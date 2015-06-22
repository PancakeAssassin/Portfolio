#include "GameObject.h"

class Brick: public GameObject
{
private:
	void (*ScorePoint)(void);
	int health;
	int pointValue;
	int currentColor;

public:
	Brick(float x, float y, int pointValue, void(*ScorePoint)(void));
	void Destroy();

	void Update();
	void Render();

	void Collided(GameObject *object);
};