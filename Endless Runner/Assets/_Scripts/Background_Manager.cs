using UnityEngine;
using System.Collections;

public class Background_Manager : MonoBehaviour {
	enum TimeOfDay{DawnToNoon, NoonToDusk, DuskToMidnight, MidnightToDawn};


	public GameObject[] hillPrefabs;
	public int numOfHills= 3;

	public Transform startHillTransform;

	public float hillLengthMin= 40.0f;
	public float hillLengthMax= 80.0f;
	public float distanceBetweenHillsMin= 0.0f;
	public float distanceBetweenHillsMax= 10.0f;
	public float hillPosZNear= 20.0f;
	public float hillPosZFar= 25.0f;

	//set dynamically
	private GameObject[] theHills;
	private GameObject anchor;
	private int leadHill;
	private float t= 0.0f;
	private float duration= 10.0f;
	private TimeOfDay ToD= TimeOfDay.DawnToNoon;
	private Color startColor;
	private Color endColor;
	public Color noon= Color.cyan;
	public Color dusk= new Color(1.0f, 0.5f, 0.0f);
	public Color midnight= new Color(0.0f, 0.06f, 0.25f);



	// Use this for initialization
	void Start () {
		theHills= new GameObject[numOfHills];

		anchor= GameObject.Find ("Background_Manager");



		GameObject hill;
		for(int i= 0; i<numOfHills; i++)
		{

			if(i == 0)
			{
				hill= CreateHill (startHillTransform);
			}
			else
			{
				hill= CreateHill(theHills[i-1].transform);
			}
			theHills[i]= hill;
		}

		leadHill= 0;
		SwitchTimeOfDay();
	}

	GameObject CreateHill(Transform prevHill)
	{
		GameObject hill;
		hill= Instantiate(hillPrefabs[0]) as GameObject;

		float hillScale= Random.Range (hillLengthMin, hillLengthMax);
		hill.transform.localScale= new Vector3(hillScale, hillPrefabs[0].transform.localScale.y, 1.0f);

		Vector3 startHill= Vector3.zero;
		float endX= prevHill.position.x + prevHill.transform.localScale.x/2.0f;

		startHill.x= Random.Range (distanceBetweenHillsMin, distanceBetweenHillsMax) + endX + hillScale/2.0f;
		startHill.y= -15.0f + Random.Range (-5.0f, 5.0f);
		startHill.z= Random.Range (hillPosZNear, hillPosZFar);

		hill.transform.position= startHill;

		hill.transform.parent= anchor.transform;

		return hill;
	}

	// Update is called once per frame
	void Update () 
	{

		if(theHills[leadHill].transform.position.x < Camera.main.transform.position.x-100.0f)
		{
			int num= leadHill;
			if(leadHill == 0)
			{
				num= numOfHills;
			}

			GameObject hill;
			hill= CreateHill(theHills[num-1].transform);
			Destroy (theHills[leadHill]);
			theHills[leadHill]= hill;
			leadHill++;
		}
		if(leadHill >= theHills.Length)
		{
			leadHill= 0;
		}


		Camera.main.backgroundColor= Color.Lerp (startColor, endColor, t);
		if(t < 1)
		{
			t+= Time.deltaTime/duration;
		}
		else
		{
			SwitchTimeOfDay();
			t= 0.0f;
		}
	}

	void SwitchTimeOfDay()
	{
		switch(ToD)
		{
		case TimeOfDay.DawnToNoon:
			ToD= TimeOfDay.NoonToDusk;
			startColor= noon;
			endColor= dusk;
			break;
		case TimeOfDay.NoonToDusk:
			ToD= TimeOfDay.DuskToMidnight;
			startColor= dusk;
			endColor= midnight;
			break;
		case TimeOfDay.DuskToMidnight:
			ToD= TimeOfDay.MidnightToDawn;
			startColor= midnight;
			endColor= dusk;
			break;
		case TimeOfDay.MidnightToDawn:
			ToD= TimeOfDay.DawnToNoon;
			startColor= dusk;
			endColor= noon;
			break;
		default:
			ToD= TimeOfDay.DawnToNoon;
			startColor= dusk;
			endColor= noon;
			break;
		}
	}
}
