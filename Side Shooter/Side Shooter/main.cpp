//Side Shooter OOP test

#include <allegro5\allegro.h>
#include <allegro5\allegro_image.h>
#include <allegro5\allegro_primitives.h>
#include <allegro5\allegro_font.h>
#include <allegro5\allegro_ttf.h>
#include <allegro5\allegro_audio.h>
#include <allegro5\allegro_acodec.h>
#include <list>

#include "GameObject.h"
#include "SpaceShip.h"
#include "Bullet.h"
#include "Comet.h"
#include "Explosion.h"
#include "Background.h"
#include "Globals.h"

bool keys[] = {false, false, false, false, false};
enum KEYS{UP, DOWN, LEFT, RIGHT, SPACE};

//globals
SpaceShip *ship;
std::list<GameObject *> objects;
std::list<GameObject *>::iterator iter;
std::list<GameObject *>::iterator iter2;
Background *titleScreen;
Background *gameOverScreen;

ALLEGRO_SAMPLE_INSTANCE *songInstance;

//prototypes
void _cdecl TakeLife();
void _cdecl ScorePoint();
void ChangeState(int &state, int newState);

int main(int argc, char **argv)
{

	bool done= false;
	bool render= false;

	float gameTime= 0;
	int frames= 0;
	int gameFPS= 0;

	ship= new SpaceShip();

	int state = -1;

	ALLEGRO_BITMAP *shipImage= NULL;
	ALLEGRO_BITMAP *cometImage= NULL;
	ALLEGRO_BITMAP *explImage= NULL;
	ALLEGRO_BITMAP *bgImage= NULL;
	ALLEGRO_BITMAP *mgImage= NULL;
	ALLEGRO_BITMAP *fgImage= NULL;
	ALLEGRO_BITMAP *titleImage= NULL;
	ALLEGRO_BITMAP *gameOverImage= NULL;
	ALLEGRO_SAMPLE *shot= NULL;
	ALLEGRO_SAMPLE *boom= NULL;
	ALLEGRO_SAMPLE *song=NULL;

	ALLEGRO_DISPLAY *display= NULL;
	ALLEGRO_EVENT_QUEUE *event_queue= NULL;
	ALLEGRO_TIMER *timer;
	ALLEGRO_FONT *font18;

	//allegro init functions
	if(!al_init())
		return -1;

	display =al_create_display(WIDTH, HEIGHT);

	if(!display)
		return -1;

	//addon install
	al_install_keyboard();
	al_init_image_addon();
	al_init_font_addon();
	al_init_ttf_addon();
	al_init_primitives_addon();
	al_install_audio();
	al_init_acodec_addon();

	//project init
	font18= al_load_font("arial.ttf", 18, 0);
	al_reserve_samples(15);

	bgImage= al_load_bitmap("starBG.png");
	mgImage= al_load_bitmap("starMG.png");
	fgImage= al_load_bitmap("starFG.png");

	Background *bg = new Background(bgImage, 1);
	objects.push_back(bg);

	bg= new Background(mgImage, 3);
	objects.push_back(bg);

	bg= new Background(fgImage, 5);
	objects.push_back(bg);

	shipImage= al_load_bitmap("spaceship.png");
	al_convert_mask_to_alpha(shipImage, al_map_rgb(255, 0, 255));
	ship->Init(shipImage);

	objects.push_back(ship);

	cometImage= al_load_bitmap("asteroid.png");
	explImage= al_load_bitmap("explosion.png");

	titleImage= al_load_bitmap("Shooter_Title.png");
	gameOverImage= al_load_bitmap("Shooter_Game_Over.png");
	
	titleScreen= new Background(titleImage, 0);
	gameOverScreen= new Background(gameOverImage, 0);

	shot= al_load_sample("shot.ogg");
	boom= al_load_sample("boom.ogg");
	song= al_load_sample("song.ogg");

	songInstance= al_create_sample_instance(song);
	al_set_sample_instance_playmode(songInstance, ALLEGRO_PLAYMODE_LOOP);
	
	al_attach_sample_instance_to_mixer(songInstance, al_get_default_mixer());

	ChangeState(state, TITLE);

	srand(time(NULL));

	//timer init and startup
	event_queue= al_create_event_queue();
	timer= al_create_timer(1.0/60);

	al_register_event_source(event_queue, al_get_timer_event_source(timer));
	al_register_event_source(event_queue, al_get_display_event_source(display));
	al_register_event_source(event_queue, al_get_keyboard_event_source());

	al_start_timer(timer);
	gameTime= al_current_time();

	while(!done)
	{
		ALLEGRO_EVENT ev;
		al_wait_for_event(event_queue,&ev);

		//display event
		if(ev.type == ALLEGRO_EVENT_DISPLAY_CLOSE)
		{
			done= true;
		}
		//INPUT
		else if(ev.type == ALLEGRO_EVENT_KEY_DOWN)
		{
			switch(ev.keyboard.keycode)
			{
			case ALLEGRO_KEY_ESCAPE:
				done= true;
				break;
			case ALLEGRO_KEY_LEFT:
				keys[LEFT]= true;
				break;
			case ALLEGRO_KEY_RIGHT:
				keys[RIGHT]= true;
				break;
			case ALLEGRO_KEY_UP:
				keys[UP]= true;
				break;
			case ALLEGRO_KEY_DOWN:
				keys[DOWN]= true;
				break;
			case ALLEGRO_KEY_SPACE:
				{
					keys[SPACE]= true;

					if(state==TITLE)
						ChangeState(state, PLAYING);
					else if(state==PLAYING)
					{
						Bullet *bullet= new Bullet(ship->GetX() + 17, ship->GetY(), &ScorePoint);
						objects.push_back(bullet);
						al_play_sample(shot, 1, 0, 1, ALLEGRO_PLAYMODE_ONCE, 0);

					}
					else if(state==GAME_OVER)
						ChangeState(state, PLAYING);

					break;
				}
			}
		}
		else if(ev.type == ALLEGRO_EVENT_KEY_UP)
		{
			switch(ev.keyboard.keycode)
			{
			case ALLEGRO_KEY_ESCAPE:
				done= true;
				break;
			case ALLEGRO_KEY_LEFT:
				keys[LEFT]= false;
				break;
			case ALLEGRO_KEY_RIGHT:
				keys[RIGHT]= false;
				break;
			case ALLEGRO_KEY_UP:
				keys[UP]= false;
				break;
			case ALLEGRO_KEY_DOWN:
				keys[DOWN]= false;
				break;
			case ALLEGRO_KEY_SPACE:
				keys[SPACE]= false;
				break;
			}
		}
		else if(ev.type ==ALLEGRO_EVENT_TIMER)
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
				if(keys[UP])
					ship->MoveUp();
				else if(keys[DOWN])
					ship->MoveDown();
				else
					ship->ResetAnimation(1);

				if(keys[LEFT])
					ship->MoveLeft();
				else if(keys[RIGHT])
					ship->MoveRight();
				else
					ship->ResetAnimation(0);

				if(rand() % 100 == 0)
				{
					Comet *comet = new Comet(WIDTH, 30 + rand() % (HEIGHT - 60), cometImage, &TakeLife);
					objects.push_back(comet);
				}
				//update
				for(iter= objects.begin(); iter != objects.end(); ++iter)
					(*iter)->Update();
				//collisions
				for(iter=objects.begin(); iter!= objects.end(); ++iter)
				{
					if(!(*iter)->Collidable()) 
						continue;
					for(iter2= iter; iter2!= objects.end(); iter2++)
					{
						if(!(*iter2)->Collidable())
							continue;

						if((*iter)->GetID() == (*iter2)->GetID())
							continue;

						if((*iter)->CheckCollisions((*iter2)))
						{
							(*iter)->Collided((*iter2)->GetID());
							(*iter2)->Collided((*iter)->GetID());

							Explosion *explosion= new Explosion(((*iter)->GetX()+ (*iter2)->GetX())/2, ((*iter)->GetY() + (*iter2)->GetY())/2, 
																explImage);

							objects.push_back(explosion);
							al_play_sample(boom, 1, 0, 1, ALLEGRO_PLAYMODE_ONCE, 0);
						}
					}
				}
				if(ship->GetLives() <= 0)
					ChangeState(state, GAME_OVER);
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

			if(state ==TITLE)
			{
				titleScreen->Render();
			}
			if(state==PLAYING)
			{
				al_draw_textf(font18, al_map_rgb(255, 0, 255), 5, 5, 0, "Lives: %i  Score: %i", ship->GetLives(), ship->GetScore());

				for(iter= objects.begin(); iter != objects.end(); ++iter)
					(*iter)->Render();
			}
			else if(state==GAME_OVER)
			{
				gameOverScreen->Render();
			}

			al_flip_display();
			al_clear_to_color(al_map_rgb(0, 0, 0));
		}
	}
	for(iter= objects.begin(); iter != objects.end(); )
	{
		(*iter)->Destroy();
		delete *iter;
		iter= objects.erase(iter);
	}

	titleScreen->Destroy();
	gameOverScreen->Destroy();
	delete titleScreen;
	delete gameOverScreen;

	al_destroy_bitmap(cometImage);
	al_destroy_bitmap(shipImage);
	al_destroy_bitmap(explImage);
	al_destroy_bitmap(bgImage);
	al_destroy_bitmap(mgImage);
	al_destroy_bitmap(fgImage);
	al_destroy_bitmap(titleImage);
	al_destroy_bitmap(gameOverImage);
	al_destroy_sample(shot);
	al_destroy_sample(song);
	al_destroy_sample_instance(songInstance);

	al_destroy_font(font18);
	al_destroy_timer(timer);
	al_destroy_event_queue(event_queue);
	al_destroy_display(display);

	return 0;
}

void _cdecl TakeLife()
{
	ship->LoseLife();
}

void _cdecl ScorePoint()
{
	ship->AddPoint();
}

void ChangeState(int &state, int newState)
{
	if(state==TITLE)
	{
	}
	else if(state==PLAYING)
	{
		for(iter= objects.begin(); iter != objects.end(); ++iter)
		{
			if((*iter)->GetID() != PLAYER && (*iter)->GetID() != MISC)
				(*iter)->SetAlive(false);
		}
		al_stop_sample_instance(songInstance);
	}
	else if(state==GAME_OVER)
	{
	}

	state= newState;

	if(state==TITLE)
	{
	}
	if(state==PLAYING)
	{
		ship->Init();
		al_play_sample_instance(songInstance);
	}
	if(state==GAME_OVER)
	{
	}

}