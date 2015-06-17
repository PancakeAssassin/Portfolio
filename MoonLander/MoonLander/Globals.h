#pragma once
enum CollisionTypes {COLLISION_NONE= 1, COLLISION_BOX= 2, 
	COLLISION_DISTANCE=3};

enum ObjectType {SHIP= 1, BACKGROUND= 2, BLOCK=3};

enum GameStates {GAME= 1};

const int MAX_SHIP_VEL= 50;
const float SHIP_RAM_SPEED= 7.9f;

const float GRAVITY=25;

const int FPS= 30;

const int SCREEN_WIDTH= 1024;
const int SCREEN_HEIGHT= 768;

const int finishW= 96;

const float friction= 5;

