#creates a checkerboard pattern using tkinter
import tkinter as tk

borderWidth= 4
borderColor= "#CCCCCC"

def drawCheckerboard(canvas, borderW, borderC, borders= True):
    drawSquares(canvas)
    if borders:
        drawBorders(canvas, borderW, borderC)

def drawSquares(canvas):
    #draw black and white squares
    i= 0
    while i < 8:
        j=0
        while j < 8:
            if (i+j) % 2 == 0:
                color= "white"
            else:
                color= "black"
            canvas.create_polygon(i*80, j*80, (i+1)*80, j*80, (i+1)*80, (j+1)*80, i*80, (j+1)*80, fill= color)
            j+=1
        i+=1

def drawBorders(canvas, borderW, borderC):
    i= 0
    #draw grey borders
    while i < 7:
        canvas.create_line((i+1)*80-borderW/2, 0,(i+1)*80 - borderW/2, 640, fill= borderC, width= borderW)
        canvas.create_line(0, (i+1)*80-borderW/2, 640, (i+1)*80 - borderW/2, fill= borderC, width= borderW)
        i+=1
    

if __name__ == '__main__':
    win= tk.Tk()
    win.title("Checkerboard")
    canvas= tk.Canvas(win, bg= "white", height=640, width= 640)
    drawCheckerboard(canvas, borderWidth, borderColor)
    canvas.pack()
    win.mainloop()
