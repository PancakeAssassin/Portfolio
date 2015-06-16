#Testing lxlm to see how to parse an xml file online
from lxml import etree
from lxml.html import parse
from lxml.html.clean import clean_html
from urllib.request import urlopen

feed= "http://www.nasdaq.com/aspxcontent/NasdaqRSS.aspx?data=quotes&symbol=GOOG&symbol=MSFT"

def GetRSSFeed(url):
    out = []
    feed = urlopen(url)
    feed = etree.parse(feed)
    feed = feed.getroot()
    for element in feed.iterfind(".//item"):
        for subel in element.iterfind(".//description"):
            desc = subel.text
            entry = desc
            out.append(entry)
    return out



def GetStockTable(file, size):
	page= parse(file)
	etree.strip_tags(page, 'a', 'img', 'font')
	data= list()
	i=0
	while i < size:
		rows= page.xpath("//table")[i*2].findall("tr")
		for row in rows:
			data.append([c.text for c in row.getchildren()])
		i+=1
	return data

if __name__ == '__main__':
	items= GetRSSFeed(feed)
	file= open('test.html', 'w')
	for i in items:
		file.write(clean_html(i))
	file.close()

	for row in GetStockTable("test.html"):
		print(row[0], end= ' ')
		if len(row) > 1:
			print(row[1], end= ' ')
		print()