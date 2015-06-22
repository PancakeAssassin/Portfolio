#include <allegro5\allegro.h>
#include <allegro5\allegro_image.h>
#include <allegro5\allegro_primitives.h>
#include <allegro5\allegro_font.h>
#include <allegro5\allegro_ttf.h>
#include <allegro5\allegro_audio.h>
#include <allegro5\allegro_acodec.h>
#include <list>

#include "GameObject.h"
#include "Background.h"
#include "Ball.h"
#include "Brick.h"
#include "Paddle.h"
#include "Globals.h"

//global variables 
Paddle *paddle;
Ball *ball;
Brick *brick;
std::list <GameObject *> objects;
std::list <GameObject *>::iterator iter;
std::list <GameObject *>::iterator iter2;

int finalScore;

Background *titleScreen;
Background *gameOverScreen;

enum KEYS{UP, DOWN, LEFT, RIGHT, SPACE, ESC};
bool keys[]= {false, false, false, false, false, false};

//prototypes
void _cdecl ScorePoint();
void _cdecl SubtractLife();
void ChangeState(int &state, int newState);

int main(int argc, char **argv)
{
	bool done= false;
	bool render= false;
	//variable that will allow the ball to deflect only once per turn
	//preventing a constant change in direction
	//vectors not used so this is best since dot product wont be calculated
	bool deflect= false;

	float gameTime= 0;
	int frames= 0;
	int gameFPS= 0;

	int state= -1;

	finalScore= 0;
	//--------------------------------------------
	//When added bitmap initialization goes here
	//--------------------------------------------

	//initialize allegro variables
	ALLEGRO_DISPLAY *display= NULL;
	ALLEGRO_EVENT_QUEUE *event_queue= NULL;
	ALLEGRO_TIMER *timer;
	ALLEGRO_FONT *font;

	if(!al_init())
		return -1;

	display= al_create_display(WIDTH, HEIGHT);

	if(!display)
		return -1;

	al_set_window_position(display, 20, 20);

	//install addons
	al_install_keyboard();
	al_init_image_addon();
	al_init_font_addon();
	al_init_ttf_addon();
	al_init_primitives_addon();
	al_install_audio();
	al_init_acodec_addon();

	//project initialization
	font= al_load_font("arial.ttf", 20, 0);
	al_reserve_samples(15);

	//initialize backgrounds, sounds, and object bitmaps here
	
	
	ChangeState(state, TITLE);
	srand(time(NULL));

	//timer init and startup
	event_queue= al_create_event_queue();
	timer= al_create_timer(1.0/ 60);

	al_register_event_source(event_queue, al_get_timer_event_source(timer));
	al_register_event_source(event_queue, al_get_keyboard_event_source());
	al_register_event_source(event_queue, al_get_display_event_source(display));

	al_start_timer(timer);
	gameTime= al_current_time();

	while(!done)
	{
		ALLEGRO_EVENT ev;
		al_wait_for_event(event_queue, &ev);

		//display event
		if(ev.type == ALLEGRO_EVENT_DISPLAY_CLOSE)
		{
			done = true;
		}

		//INPUT
		else if(ev.type == ALLEGRO_EVENT_KEY_DOWN)
		{
			switch(ev.keyboard.keycode)
			{
			case ALLEGRO_KEY_ESCAPE:
				done= true;
				break;
			case ALLEGRO_KEY_UP:
				keys[UP]= true;
				break;
			case ALLEGRO_KEY_DOWN:
				keys[DOWN]= true;
				break;
			case ALLEGRO_KEY_LEFT:
				keys[LEFT]= true;
				break;
			case ALLEGRO_KEY_RIGHT:
				keys[RIGHT]= true;
				break;
			case ALLEGRO_KEY_SPACE:
				keys[SPACE]= true;
				if(state==TITLE)
					ChangeState(state, PLAYING);
				else if(state== PLAYING)
				{
					//Space will be used to activate powers 
				}
				else if(state==GAME_OVER)
					ChangeState(state, PLAYING);
				break;
			}
		}
		else if(ev.type == ALLEGRO_EVENT_KEY_UP)
		{
			switch(ev.keyboard.keycode)
			{
			case ALLEGRO_KEY_ESCAPE:
				done= true;
				break;
			case ALLEGRO_KEY_UP:
				keys[UP]= false;
				break;
			case ALLEGRO_KEY_DOWN:
				keys[DOWN]= false;
				break;
			case ALLEGRO_KEY_LEFT:
				keys[LEFT]= false;
				break;
			case ALLEGRO_KEY_RIGHT:
				keys[RIGHT]= false;
				break;
			case ALLEGRO_KEY_SPACE:
				keys[SPACE]= false;
				break;
			}
		}
		else if(ev.type == ALLEGRO_EVENT_TIMER)
		{
			render= true;
			frames++;
			if(al_current_time() - gameTime >= 1)
			{
				gameTime= al_current_time();
				gameFPS= frames;
				frames= 0;
			}
			if(state==PLAYING)
			{
				deflect= true;
				if(keys[LEFT])
					paddle->MoveLeft();
				else if(keys[RIGHT])
					paddle->MoveRight();
				else
					paddle->ResetAnimation();

				//update
				for(iter= objects.begin(); iter!= objects.end(); ++iter)
					(*iter)->Update();
				//collisions
				for(iter= objects.begin(); iter!= objects.end(); ++iter)
				{
					if(!(*iter)->Collidable() && !(*iter)->GetAlive())
						continue;
					for(iter2= objects.begin(); iter2!= objects.end(); iter2++)
					{
						if(!(*iter2)->Collidable() && !(*iter2)->GetAlive())
							continue;

						if((*iter)->GetID()== (*iter2)->GetID())
							continue;
						
						if((*iter)->GetID() == BALL && !deflect)
							continue;

						if((*iter)->CheckCollisions(*iter2))
						{
							(*iter)->Collided((*iter2));
							//(*iter2)->Collided((*iter)->GetID());
							if((*iter)->GetID() == BALL)
								deflect= false;
							//play sounds and such in here
						}
					}
				}

				if(paddle->GetLives() <= 0)
				{
					finalScore= paddle->GetScore();
					ChangeState(state, GAME_OVER);
				}
			}
			for(iter= objects.begin(); iter != objects.end(); )
			{
				if(!(*iter)->GetAlive())
				{
					delete (*iter);
					iter= objects.erase(iter);
				}
				else
					iter++;
			}
		}
		//render
		if(render && al_is_event_queue_empty(event_queue))
		{
			render= false;
			if(state== TITLE)
			{
				al_draw_textf(font, al_map_rgb(0, 255, 255), WIDTH/2, HEIGHT/2, ALLEGRO_ALIGN_CENTRE, "BRICK BREAKER PROTOTYPE");
				al_draw_textf(font, al_map_rgb(0, 255, 255), WIDTH/2, (HEIGHT/2) + 25, ALLEGRO_ALIGN_CENTRE, "HIT SPACE TO PLAY");
			}
			else if(state== PLAYING)
			{
				al_draw_textf(font, al_map_rgb(0, 0, 255), WIDTH/2, 5, ALLEGRO_ALIGN_CENTRE, "SCORE: %i   LIVES: %i", paddle->GetScore(), paddle->GetLives());
				for(iter= objects.begin(); iter != objects.end(); ++iter)
					(*iter)->Render();
			}
			else if(state==GAME_OVER)
			{
				al_draw_textf(font, al_map_rgb(255, 0, 0), WIDTH/ 2, HEIGHT/ 2, ALLEGRO_ALIGN_CENTRE, "GAME OVER! FINAL SCORE: %i", finalScore);
			}
			
			al_flip_display();
			al_clear_to_color(al_map_rgb(255, 255, 255));
		}

	}

	for(iter= objects.begin(); iter != objects.end(); )
	{
		(*iter)->Destroy();
		delete *iter;
		iter= objects.erase(iter);
	}

	al_destroy_font(font);
	al_destroy_timer(timer);
	al_destroy_event_queue(event_queue);
	al_destroy_display(display);
	return 0;
}

void _cdecl SubtractLife()
{
	paddle->LoseLife();
}


void _cdecl ScorePoint()
{
	paddle->AddPoint();
}
void ChangeState(int &state, int newState)
{
	if(state==TITLE)
	{}
	else if(state==PLAYING)
	{
		for(iter= objects.begin(); iter!= objects.end(); ++iter)
		{
				(*iter)->SetAlive(false);
		}
	}
	else if(state==GAME_OVER)
	{}

	state= newState;

	if(state==TITLE)
	{}
	if(state==PLAYING)
	{
		finalScore= 0;
		ball= new Ball(&SubtractLife);
		paddle= new Paddle();
		paddle->Init();
		ball->Reset();
		objects.push_back(paddle);
		objects.push_back(ball);

		for(int i= 0; i< (sizeof(level1)/sizeof(*level1)); ++i)
		{
			if(level1[i])
			{
				brick= new Brick((i%10)*80,(i/10)*32 + 35, 3, &ScorePoint);
				objects.push_back(brick);
			}
		}

	}
	if(state==GAME_OVER)
	{}

}