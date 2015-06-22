#include "GameObject.h"

class Ball: public GameObject
{
private:
	int maxSpeed;
	int curSpeed;
	int speedIncDelay;
	int counter;

	void(*SubtractLife)(void);

public:
	Ball(void(*SubtractLife)(void));
	//void Init(float x, float y);
	void Destroy();

	void Update();
	void Render();

	void Reset();
	void Collided(GameObject *object);
};