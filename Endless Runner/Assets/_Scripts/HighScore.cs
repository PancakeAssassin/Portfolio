using UnityEngine;
using UnityEngine.UI;
using System.Collections;

public class HighScore : MonoBehaviour {

	static public int score= 100;

	void Awake()
	{
		//if there already exists a highScore, read it
		if(PlayerPrefs.HasKey ("HighScore0"))
		{
			score= PlayerPrefs.GetInt ("HighScore0");
		}
		PlayerPrefs.SetInt ("HighScore0", score);
	}

	// Use this for initialization
	void Start () {
		Text highScore= gameObject.GetComponent<Text>();
		highScore.text= "High Score: "+ score.ToString();
	}
	
	// Update is called once per frame
	void Update () {
		Text highScore= gameObject.GetComponent<Text>();
		highScore.text= "High Score: " +score.ToString();

		/*//update HighScore in playerPrefs if necessary
		if(score > PlayerPrefs.GetInt ("HighScore0"))
		{
			PlayerPrefs.SetInt("HighScore0", score);
		}*/
	}

	public static void checkForHighScore(int theScore)
	{
		for(int i= 0; i< 10; i++)
		{
			if(checkAgainstRank(theScore, i))
			{
				shiftDownRanks(i);
				string scoreKey= "HighScore"+i;
				PlayerPrefs.SetInt (scoreKey, theScore);
				return;
			}
		}
	}

	static bool checkAgainstRank(int theScore, int i)
	{
		if(i < 0 || i > 9)
		{
			return false;
		}
		string scoreKey= "HighScore"+i;
		if(score > PlayerPrefs.GetInt (scoreKey))
		{
			return true;
		}
		return false;
	}

	static void shiftDownRanks(int i)
	{
		string currentScoreKey;
		string downScoreKey;
		int score;
		for(int j= 9; j > i; j--)
		{
			downScoreKey= "HighScore"+j;
			currentScoreKey="HighScore"+(j-1);
			if(PlayerPrefs.HasKey(currentScoreKey))
			{
				score= PlayerPrefs.GetInt(currentScoreKey);
				PlayerPrefs.SetInt(downScoreKey, score);
			}
		}
	}
}
