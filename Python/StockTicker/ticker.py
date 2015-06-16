#Genesis Stock Ticker
#Chris Minda
import sys
import tkinter as tk
import lxmlTest as prsr
from lxml import etree
from lxml.html.clean import clean_html

class Ticker(tk.Frame):
	def __init__(self, parent):
		tk.Frame.__init__(self, parent)
		
		self.parent= parent
		self.stocks= []
		self.initUI()
		
	def initUI(self):
		self.parent.title("Genesis Stock Ticker")
		
		
		#create menu bar
		menuBar= tk.Menu(self.parent)
		self.parent.config(menu= menuBar)
		
		fileMenu= tk.Menu(menuBar)
		fileMenu.add_command(label= 'Exit', command= sys.exit)
		menuBar.add_cascade(label= 'File', menu= fileMenu)
		
		editMenu= tk.Menu(menuBar)
		editMenu.add_command(label= 'Add Stock', command= self.addStock)
		editMenu.add_command(label= 'Remove Stock', command= self.removeStock)
		menuBar.add_cascade(label= 'Edit', menu= editMenu)
		
	def updateStocks(self, url):
		pass
	
	def displayStock(self):
		feed= "http://www.nasdaq.com/aspxcontent/NasdaqRSS.aspx?data=quotes&symbol=GOOG&symbol=MSFT&symbol=SNE" 
		items= prsr.GetRSSFeed(feed)
		file= open('test.html', 'w')
		for i in items:
			file.write(clean_html(i))
		file.close()
		
		rows= prsr.GetStockTable("test.html", 3)
		n= 0
		for r in rows:
			if n%5 != 0:
				print(n)
				tk.Label(self.parent, text=r[0], relief= tk.RIDGE).grid(row= n)
				tk.Label(self.parent, text= r[1], relief= tk.RIDGE).grid(row=n, column=1)
			else:
				tk.Label(self.parent, text=r[0], relief= tk.GROOVE).grid(row=n)		
			n+=1
		
		
	def addStock(self):
		stock= input('Enter a stock to add to the ticker: ')
		self.stocks.append(stock)
		
	def removeStock(self):
		stock= input('Enter a stock to remove from the ticker: ')
		if stock in self.stocks:
			self.stocks.remove(stock)
		

class Feed():
	def __init__(self, feed= "http://www.nasdaq.com/aspxcontent/NasdaqRSS.aspx?data=quotes"):
		self.feed= feed
		pass
	
	def pullDown(self):
		pass
		
	def addStock(self, symbol):
		self.feed+="&symbol=" + symbol
	
	
class Stock():
	def __init__(self):
		pass

if __name__=='__main__':
	master= tk.Tk()
	tick= Ticker(master)
	tick.displayStock()
	master.mainloop()