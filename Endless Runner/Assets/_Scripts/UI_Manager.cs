using UnityEngine;
using System.Collections;

public class UI_Manager : MonoBehaviour {

	public void StartGame()
	{
		Application.LoadLevel("_scene_0");
	}

	public void MainMenu()
	{
		Application.LoadLevel ("_scene_title");
	}

	public void HighScores()
	{
		Application.LoadLevel ("_scene_scores");
	}
}
