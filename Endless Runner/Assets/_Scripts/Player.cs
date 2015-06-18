
using UnityEngine;
using UnityEngine.UI;
using System.Collections;

public class Player : MonoBehaviour {

	bool onGround;
	public Transform startingPos;
	public float jumpForce= 10.0f;
	public Vector3 startingForwardSpeed= new Vector3(2.0f, 0.0f, 0.0f);
	public float forwardAccel= 0.5f;
	public Text scoreText;
	public Text gameOverText;
	public Button restart;
	public Button highScores;
	public Button exit;

	//set dynamically
	private Vector3 forwardSpeed;
	private float forwardForce=10.0f;
	private bool ducked= false; 
	private bool hitTunnelWall= false;
	private bool gameOver= false;
	private float score;

	// Use this for initialization
	void Start () {
		transform.position= new Vector3(startingPos.position.x,
		                                startingPos.position.y + 1.0f,
		                                startingPos.position.z);
		gameOver= false;
		forwardSpeed= startingForwardSpeed;
		onGround= true;
		score= 0.0f;
	}
	
	// Update is called once per frame
	void Update () {

		rigidbody.MovePosition(rigidbody.position + forwardSpeed * Time.deltaTime);
		//if it isn't gameOver, increment the score
		if(!gameOver)
		{
			score+= forwardSpeed.x * Time.deltaTime;
			scoreText.text= ((int)score).ToString();

			if((int)score > HighScore.score)
			{
				HighScore.score= (int)score;
			}

			forwardSpeed.Set (forwardSpeed.x + forwardAccel * Time.deltaTime,
		                  forwardSpeed.y,
		                  forwardSpeed.z);
			if(Input.GetButton("Jump") && onGround)
			{
				Jump();
			}
			if(Input.GetButtonDown ("Duck") && onGround)
			{
				print ("Ducking");
				Duck ();
			}
			if(Input.GetButtonUp("Duck"))
			{
				print("Finished Ducking");
				ReturnFromDucking();
			}

			if(transform.position.y < -6.0f)
			{
				print ("game over text enabled!");
				gameOverText.gameObject.SetActive(true);
				restart.gameObject.SetActive(true);
				highScores.gameObject.SetActive(true);
				exit.gameObject.SetActive(true);
				gameOver= true;
				HighScore.checkForHighScore((int)score);
			}
		}
	}

	void OnCollisionEnter(Collision col)
	{
		if(col.gameObject.tag == "Platform")
		{
			if(transform.position.y > col.gameObject.transform.position.y + col.gameObject.transform.localScale.y/2.0f + .25f)
			{
				print("Back on the ground");
				onGround= true;
				if(hitTunnelWall)
				{
					ResetMovement();
					hitTunnelWall= false;
				}
			}
			else if(transform.position.x < 
			        col.gameObject.transform.position.x - col.gameObject.transform.localScale.x/2.0f &&( 
			        (transform.position.y - transform.localScale.y/2.0f < 
			        col.gameObject.transform.position.y + col.gameObject.transform.localScale.y/2.0f && !ducked)
			        || (transform.position.y < col.gameObject.transform.position.y + col.gameObject.transform.localScale.y/2.0f 
			        && ducked)))
			{
				print ("Enter platform side collision");
				ReboundOffWall();
			}
		}
		else if(col.gameObject.tag == "TunnelTop")
		{
			if(transform.position.x < 
			   col.gameObject.transform.position.x - col.gameObject.transform.localScale.x/2.0f)
			{
				print ("Enter tunnel side collision");
				StopMovement ();
				hitTunnelWall= true;
			}
			else if(transform.position.y + transform.localScale.y/2.0f > 
			        col.gameObject.transform.position.y + .25f)
			{
				print ("Ceiling of tunnel hit");
				SlowMovement ();
			}
		}
		else if(col.gameObject.tag == "Obstacle")
		{
			ResetMovement();
			Destroy (col.gameObject, .5f);
		}
	}

	void OnCollisionExit(Collision col)
	{
		if(col.gameObject.tag == "Platform")
		{
			onGround=false;
		}
	}

	void Jump()
	{
		rigidbody.AddForce(forwardForce, jumpForce, 0.0f);
		onGround= false;
	}

	void Duck()
	{
		if(!ducked)
		{
			transform.RotateAround(transform.position, Vector3.forward, 90);
			ducked= true;
		}
	}

	void ReturnFromDucking()
	{
		if(ducked)
		{
			transform.RotateAround(transform.position, Vector3.forward, -90);
			ducked= false;
		}
	}

	void ResetMovement()
	{
		forwardSpeed= startingForwardSpeed;
		forwardAccel=.5f;
	}

	void StopMovement()
	{
		forwardSpeed.Set(0.0f, 0.0f, 0.0f);
		forwardAccel= 0.0f;
	}

	void ReboundOffWall()
	{
		forwardSpeed.Set(0.0f, 0.0f, 0.0f);
		forwardAccel= -1.0f;
	}

	void SlowMovement()
	{
		forwardSpeed.Set (forwardSpeed.x * 2 /3.0f, 0.0f, 0.0f);
	}
}
