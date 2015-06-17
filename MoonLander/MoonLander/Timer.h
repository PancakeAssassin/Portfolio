#ifndef TIMER_H
#define TIMER_H

#include "Globals.h"
#include <SDL.h>

class Timer
{
private:
	int startTicks;
	int pausedTicks;

	bool paused;
	bool started;

public:
	Timer();

	void start();
	void stop();
	void pause();
	void unpause();

	int getTicks();

	bool isStarted();
	bool isPaused();
};

#endif