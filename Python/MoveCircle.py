#Creates a TKinter window and has button controls to move a circle up down left
# and right
import tkinter as tk

canvasWidth= 200
canvasHeight= 200


class Circle:

    def __init__(self, x, y, r, canvas,  fillColor= "white"):
        self.__x= x
        self.__y= y
        self.__r= r
        self.__color= fillColor
        self.__canvas= canvas
        
    def drawCircle(self):
        self.__canvas.delete("all")
        self.__canvas.create_oval(self.__x - self.__r, self.__y - self.__r, self.__x + self.__r, self.__y + self.__r, fill= self.__color)

    def moveRight(self):
        self.__x += 5 
        if self.__x + self.__r > canvasWidth:
            self.__x = canvasWidth - (2*self.__r)
        self.drawCircle()
        
    def moveLeft(self):
        self.__x -= 5
        if self.__x - self.__r < 0:
            self.__x = (2*self.__r)
        self.drawCircle()
        
    def moveUp(self):
        self.__y -= 5
        if self.__y - self.__r < 0:
            self.__y= (2*self.__r)
        self.drawCircle()
        
    def moveDown(self):
        self.__y += 5
        if self.__y + self.__r > canvasHeight:
            self.__y = canvasHeight - (2*self.__r)
        self.drawCircle()
root= tk.Tk()
root.title("Move Circle")
canvas= tk.Canvas(root, width=canvasWidth, height= canvasHeight, borderwidth= 0, bg= "white")
canvas.pack()
c= Circle(50, 50, 3, canvas, fillColor= "red")
frame= tk.Frame(root)
frame.pack(side = tk.BOTTOM)
l= tk.Button(frame, text= "Left", command= c.moveLeft)
l.pack(side= tk.LEFT)
r= tk.Button(frame, text= "Right", command= c.moveRight)
r.pack(side= tk.LEFT)
u= tk.Button(frame, text= "Up", command= c.moveUp)
u.pack(side=tk.LEFT)
d= tk.Button(frame, text= "Down", command= c.moveDown)
d.pack(side= tk.LEFT)

c.drawCircle()

root.mainloop()
