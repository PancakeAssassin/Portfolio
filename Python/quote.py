#displays a new quote to a Tkinter window daily when opened
import sys
import tkinter as tk
from lxml import etree
from urllib.request import urlopen
import tkinter as tk
feed= "http://feeds.feedburner.com/brainyquote/QUOTEBR"

def GetRSSFeed(url):
	out = []
	feed = urlopen(url)
	feed = etree.parse(feed)
	feed = feed.getroot()
	for element in feed.iterfind(".//item"):
		elem= {}
		for subel in element.iterfind(".//*"):
			if subel.tag == 'description':
				elem['quote'] = subel.text
			elif subel.tag == 'title':
				elem['author'] = subel.text
		out.append(elem)
	return out

	
class QuoteWindow(tk.Frame):
	def __init__(self, parent):
		self.parent= parent
		
		self.initUI()
	
	def initUI(self):
		self.parent.title("Quote of the Day!")
		
	def displayQuote(self, url):
		quotes= GetRSSFeed(url)
		#quote= quotes[0]
		tk.Label(self.parent, text= quotes[0]['quote']).grid(column=0)
		tk.Label(self.parent, text= quotes[0]['author']).grid(column=1)

if __name__ == '__main__':
	master= tk.Tk()
	quote= QuoteWindow(master)
	quote.displayQuote(feed)
	master.mainloop()