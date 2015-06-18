using UnityEngine;
using System.Collections;

public class PlatformManager : MonoBehaviour {
	//fields set in unity inspector
	public GameObject[] platformPrefabs;
	public GameObject[] obstaclePrefabs;

	public float platformLengthMin= 10.0f;
	public float platformLengthMax= 20.0f;
	public float platformHeightDifference= 3.0f;
	public float minDistBetweenPlatforms= 1.5f;
	public float maxDistBetweenPlatforms= 2.5f;
	public float lowestPlatformHeight= -6.0f;
	public float distanceFromCameraForDestruction= 10.0f;
	public int numPlatforms= 10;
	public float chanceForObstacle= 0.1f;

	public Transform firstBlockPos;

	public bool ____________________________________________________________________;

	//fields set dynamically
	private GameObject[] platforms;
	private GameObject anchor;
	private int nextPlatformToReset;
	private int prevScale;
	private bool prevWasTunnel;

	void Awake()
	{

	}

	// Use this for initialization
	void Start () {

		//instantiate platforms to hold the max number of platforms
		//at any one instance
		platforms= new GameObject[numPlatforms];

		//find the platform manager object
		anchor= GameObject.Find("Platform_Manager");

		GameObject platform;
		
		platform = Instantiate (platformPrefabs[0], firstBlockPos.position, firstBlockPos.rotation) as GameObject;
		float platScale= Random.Range (platformLengthMax/2.0f, platformLengthMax);
		platform.transform.localScale= new Vector3(platScale, 1.0f, 1.0f);
		platform.transform.parent= anchor.transform;

		platforms[0]= platform;
		prevWasTunnel= false;
		
		//iterate through the platforms that must be created
		for(int i=1; i<numPlatforms; i++)
		{
			if(Random.value < .9f)
			{
				platform= createPlatform (i);

				platforms[i]= platform;
			}
			else
			{
				platform= createTunnel(i);
				platforms[i]= platform;
			}
		}
		nextPlatformToReset= 0;
	}


	GameObject createPlatform(int i)
	{
		GameObject platform;

		//int prefabNum= Random.Range (0, platformPrefabs.Length);
		
		//create an instance
		platform= Instantiate(platformPrefabs[0]) as GameObject;
		
		//scale the platform accordingly
		float platScale= Random.Range (platformLengthMin, platformLengthMax); 
		platform.transform.localScale= new Vector3(platScale, 1.0f, 1.0f);
		
		//position of the platform
		Vector3 platformPos= Vector3.zero;

		//gets the end of the platform
		float endX= platforms[i-1].transform.position.x + platforms[i-1].transform.localScale.x/2.0f;
		if(!prevWasTunnel)
		{
			//determine where the next platform should spawn
			platformPos.x= Random.Range (endX + minDistBetweenPlatforms, 
		                             endX + maxDistBetweenPlatforms) + platScale/2;
			do
			{
				platformPos.y= Random.Range (platforms[i-1].transform.position.y - platformHeightDifference, 
		                        platforms[i-1].transform.position.y + platformHeightDifference);
		
			} while(platformPos.y < lowestPlatformHeight);
		}
		else
		{
			platformPos.x= endX + platScale/2.0f;
			platformPos.y= platforms[i-1].transform.position.y -.5f;
		}
		platform.transform.position= platformPos;

		//make the platform a child of the anchor
		platform.transform.parent= anchor.transform;
		
		//prevPlatformPos= platformPos + new Vector3(platScale/2.0f, 0.0f, 0.0f);
		prevWasTunnel= false;

		//do a check to see if the platform should have an obstacle on it and create it
		if(Random.value < chanceForObstacle)
		{
			createObstacle(platform.transform);
		}

		return platform;
	}

	//CREATE TUNNEL
	//creates a tunnel so that it attaches to the previous regular platform
	GameObject createTunnel(int i)
	{

		GameObject tunnel;

		//create an instance
		tunnel= Instantiate (platformPrefabs[1]) as GameObject;

		//determine the length of the tunnel
		float tunnelScale= Random.Range (platformLengthMin, platformLengthMax);
		tunnel.transform.localScale= new Vector3(tunnelScale, 1.0f, 1.0f);

		//position of the tunnel
		Vector3 tunnelPos= Vector3.zero;

		//determine where the tunnel must be setup so it connects directly with the previous platform
		tunnelPos.x = platforms[i-1].transform.position.x + platforms[i-1].transform.localScale.x/2.0f + tunnelScale/2.0f;
		if(prevWasTunnel)
			tunnelPos.y= platforms[i-1].transform.position.y;
		else
			tunnelPos.y = platforms[i-1].transform.position.y + platforms[i-1].transform.localScale.y/2.0f;
		tunnel.transform.position= tunnelPos;

		//make the tunnel a child of the anchor
		tunnel.transform.parent= anchor.transform;

		prevWasTunnel= true;

		return tunnel;
	}

	//CREATEOBSTACLE
	//method to create a new obstacle on a platform
	void createObstacle(Transform platformT)
	{
		GameObject obstacle;
		obstacle= Instantiate(obstaclePrefabs[0]) as GameObject;


		//place the obstacle on the platform 
		Vector3 obstaclePos= Vector3.zero;

		obstaclePos.x= Random.Range (platformT.position.x + 0.5f - (platformT.localScale.x/2.0f), 
		                             platformT.position.x - 0.5f + (platformT.localScale.x/2.0f));
		obstaclePos.y= platformT.position.y + platformT.localScale.y/2.0f + obstacle.transform.localScale.y/2.0f;

		obstacle.transform.position = obstaclePos;
	}

	// Update is called once per frame
	void Update () 
	{
		if(platforms[nextPlatformToReset].transform.position.x < Camera.main.transform.position.x - distanceFromCameraForDestruction)
		{
			int num= nextPlatformToReset;
			if( nextPlatformToReset == 0)
				num= numPlatforms;
			if(Random.value < .9f)
			{
				GameObject platform= createPlatform(num);
				Destroy (platforms[nextPlatformToReset]);
				platforms[nextPlatformToReset]= platform;
			}
			else
			{
				GameObject platform= createTunnel(num);
				Destroy (platforms[nextPlatformToReset]);
				platforms[nextPlatformToReset]= platform;
			}
			nextPlatformToReset++;
			if(nextPlatformToReset >= numPlatforms)
			{
				nextPlatformToReset= 0;
			}
		}
	}

	void FixedUpdate()
	{

	}
}