using UnityEngine;
using System.Collections;

public class Camera_Manager : MonoBehaviour {


	//contains handle to player so the camera follows her
	public Transform player;

	// Use this for initialization
	void Start () {
	
	}
	
	// Update is called once per frame
	void Update () {
		Vector3 playerPos= player.position;
		playerPos.z-= 20;
		transform.position= playerPos;
	}

}
