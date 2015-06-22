#pragma once

const int WIDTH		= 800;
const int HEIGHT	= 600;

const int MAXSPEED= 15;
const int CURSPEED= 7;

enum ID{PLAYER, BRICK, BALL, MISC, BORDER};
enum STATE{TITLE, PLAYING, GAME_OVER};

const int level1[] =  {0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 
					   0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 
					   0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 
					   0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 
					   0, 1, 1, 1, 1, 1, 1, 1, 1, 0};