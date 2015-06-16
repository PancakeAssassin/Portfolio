#Creates a Koch Snowflake Fractal
import tkinter as tk
import turtle as turt

def createSnowflake():
    order= int(kochEntry.get())
    size= 120
    canvas.delete(tk.ALL)
    t= turt.RawTurtle(canvas)
    t.ht()
    t.pu()
    t.goto(-240, -150)
    t.pd()
    t.speed(10)
    snowflakeHelper(t, 480, order)
    t.left(120)
    snowflakeHelper(t, 480, order)
    t.left(120)
    snowflakeHelper(t, 480, order)

def snowflakeHelper(t, size, order):
    if order == 0:
        t.forward(size)
    else:
        snowflakeHelper(t, size/3, order -1)
        t.right(60)
        snowflakeHelper(t, size/3, order -1)
        t.right(-120)
        snowflakeHelper(t, size/3, order -1)
        t.right(60)
        snowflakeHelper(t, size/3, order -1)
        
        


root= tk.Tk()
root.title("Koch Snowflake")
canvas= tk.Canvas(root, width= 800, height= 600)
canvas.pack(side= tk.TOP)
frame= tk.Frame()
frame.pack(side= tk.BOTTOM)
label= tk.Label(frame, text="Enter an order")
label.pack(side= tk.LEFT)
kochEntry= tk.Entry(frame)
kochEntry.pack(side= tk.LEFT)
kochEntry.focus_set()


    


submit= tk.Button(frame, text= "Display", command= createSnowflake)
submit.pack(side= tk.LEFT)

root.mainloop()
