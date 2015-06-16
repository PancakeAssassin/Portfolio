#checks whether two rectangles intersect each other in a window
import turtle

def drawAndCheck(cx1, cy1, w1, h1, cx2, cy2, w2, h2):
    draw((cx1-w1/2), (cy1+h1/2), w1, h1)
    draw((cx2-w2/2), (cy2+h2/2), w2, h2)

    check(cx1, cy1, w1, h1, cx2, cy2, w2, h2)
    
    

def draw(x, y, w, h):
    turtle.penup()
    turtle.setheading(0)
    turtle.goto(x,y)
    turtle.pendown()
    turtle.forward(w)
    turtle.right(90)
    turtle.forward(h)
    turtle.right(90)
    turtle.forward(w)
    turtle.right(90)
    turtle.forward(h)

def check(cx1, cy1, w1, h1, cx2, cy2, w2, h2):
    #calc left right top and bottom of rectangle 
    l1= cx1- w1/2
    r1= cx1+ w1/2
    t1= cy1+ h1/2
    b1= cy1- h1/2

    l2= cx2- w2/2
    r2= cx2+ w2/2
    t2= cy2+ h2/2
    b2= cy2- h2/2

    #check if one rectangle falls within the bounds of another
    if (l1 <= r2 and r1 >= l2 and t1 >= b2 and b1 <= t2) or \
       (l2 <= r1 and r2 >= l1 and t2 >= b1 and b2 <= t1):
        if l1 == l2 and r1 == r2 and t1 == t2 and b1 == b2:
            turtle.write("this is the same rectangle")
        elif l1 < l2 and r1 > r2 and t1 > t2 and b1 < b2:
            #rect2 is inside rect1
            turtle.write("r2 is inside r1")
        elif l2 < l1 and r2 > r1 and t2 > t1 and b2 < b1:
            #rect1 is inside rect2
            turtle.write("r1 is inside r2")
        else:
            #the rectangles are just overlapping
            turtle.write("r1 and r2 intersect each other")
    else:
        #check failed no overlap
        turtle.write("No intersection")

if __name__ =='__main__':
    cx1, cy1, h1, w1= input("Enter r1's center x-, y-coordinates, width, and height: ").split(',')
    cx2, cy2, h2, w2= input("Enter r2's center x-, y-coordinates, width, and height: ").split(',')
    drawAndCheck(int(cx1), int(cy1), int(h1), int(w1), int(cx2), int(cy2), int(h2), int(w2))

