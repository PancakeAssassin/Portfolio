using UnityEngine;
using UnityEngine.UI;
using System.Collections;

public class HighScoreList : MonoBehaviour {

	// Use this for initialization
	void Start () {
		Text highScoreList= gameObject.GetComponent<Text>();
		string listText= "";
		for(int i = 0; i <10; i++)
		{
			string key= "HighScore"+i;
			if(PlayerPrefs.HasKey (key))
			{
				string rowString= (i+1).ToString()+".";
				rowString+= "\t" + PlayerPrefs.GetInt(key);
				listText+= rowString + "\n";
				print(rowString);
			}
			else
			{
				break;
			}
		}
		highScoreList.text= listText;
	
	}

}
