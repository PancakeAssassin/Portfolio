#uses tkinter for a simple connect 4 game
import tkinter as tk

canvasWidth= 700
canvasHeight= 600
radius=10

class GameBoard:
    def __init__(self, parent):
        self.__ROWS= 6
        self.__COLS= 7
        self.__playerStatus= []
        self.__winner= -1
        self.__currentPlayer= 0
        self.__gameOver= False
        self.__parent= parent
        self.__canvas= tk.Canvas(self.__parent, width= canvasWidth, height= canvasHeight)
        self.__canvas.pack()
        self.__sqWidth= canvasWidth / self.__COLS
        self.__sqHeight= canvasHeight / self.__ROWS
        self.__lastIndex= -1
        moveFrame= tk.Frame(self.__parent)
        moveFrame.pack(side= tk.BOTTOM)
        self.__question= tk.StringVar()
        self.__moveQ= tk.Label(moveFrame, textvariable= self.__question).pack() 

    def beginGame(self):
        self.__winner= -1
        self.__currentPlayer= 1
        self.__gameOver= False
        self.__playerStatus= [-1]*(self.__ROWS * self.__COLS)
        self.__lastIndex= -1
        self.__question.set(self.askMove())
        self.render()

    def render(self):
        self.drawBoard()
        self.drawDisks()
        
        
    def drawBoard(self):
        self.__canvas.delete(tk.ALL)
        i = 0 
        self.__canvas.create_rectangle(0, 0, canvasWidth, canvasHeight, fill= "yellow")

        i = 0
        while i < self.__ROWS:
            self.__canvas.create_line(0, i* self.__sqHeight - 1, canvasWidth, i * self.__sqHeight -1, width= 2)
            i+=1
        j = 0
        while j < self.__COLS:
            self.__canvas.create_line(j * self.__sqWidth - 1, 0, j * self.__sqWidth - 1, canvasHeight, width= 2)
            j+= 1
            

    def drawDisks(self):
        i = 0
        while i < self.__ROWS:
            j = 0
            while j < self.__COLS: 
                if self.__playerStatus[i*self.__COLS+ j] == 1:
                    self.drawDisk(j*self.__sqWidth + self.__sqWidth/2, i*self.__sqHeight + self.__sqHeight/2, "red")
                elif self.__playerStatus[i*self.__COLS+ j] == 2:
                    self.drawDisk(j*self.__sqWidth + self.__sqWidth/2, i*self.__sqHeight + self.__sqHeight/2, "black")
                j+= 1
            print()
            i+= 1

            
    def drawDisk(self, x, y, playerColor):
        self.__canvas.create_oval(x - radius, y - radius, x + radius, y + radius, fill= playerColor)

    def dropDisk(self, col, player):
        if self.__playerStatus[col] == -1:
            i = 1
            placed= False
            while i < 6 and placed== False:
                if self.__playerStatus[i*self.__COLS + col] != -1:
                    self.__playerStatus[(i-1)*self.__COLS + col]= player
                    self.__lastIndex= (i-1) * self.__COLS + col
                    placed= True
                i+=1
            if placed == False:
                self.__playerStatus[(i-1)*self.__COLS + col]= player
                self.__lastIndex= (i-1) * self.__COLS + col
            self.render()
            if self.checkWin(self.__currentPlayer, self.__lastIndex):
                self.__winner= self.__currentPlayer
                self.__gameOver= True
                message= "Player " + str(self.__winner) + " wins.\n Do you want to play again?"
                result= tk.messagebox.askyesno("G A M E    O V E R", message )
                if result == True:
                    self.beginGame()
                else:
                    self.__parent.destroy()
                
            if self.__currentPlayer == 1:
                self.__currentPlayer = 2
            else:
                self.__currentPlayer = 1
            self.__question.set(self.askMove())
        else:
            print("Choose another column.")

    def checkWin(self, player, recentIndex):

        if self.checkRow(player, recentIndex):
            self.__winner= player
            #print("Winner by row")
            return True
        if self.checkCol(player, recentIndex):
            #print("Winner by col")
            self.__winner= player
            return True
        if self.checkDiagLR(player, recentIndex):
            self.__winner= player
            #print("Winner by DiagLR")
            return True
        if self.checkDiagRL(player, recentIndex):
            self.__winner= player
            #print("Winner by DiagRL")
            return True

        return False

    def checkRow(self, player, recentIndex):
        low= recentIndex - (recentIndex % self.__COLS) 
        high= low + 6
        furthestRight= recentIndex
        furthestLeft= recentIndex
        #check for disk for player that is further left
        j= 1
        while (recentIndex -j) >= low and self.__playerStatus[recentIndex - j] == player:
            furthestLeft-=1
            j+=1
        #check for disk for player that is further right
        i= 1
        while (recentIndex+ i) < high and self.__playerStatus[recentIndex + i] == player:
            furthestRight+= 1
            i+=1

        if furthestRight - furthestLeft >= 3:
            return True
        else:
            return False
        

    def checkCol(self, player, recentIndex):
        #lowest index vertically to check
        low= recentIndex % self.__COLS
        high= ((self.__COLS * self.__ROWS) - (self.__COLS)) + low

        furthestUp = recentIndex
        furthestDown = recentIndex

        #check for disk for player that is furthest up
        j= 1
        while (recentIndex- (j*self.__COLS)) >= low and self.__playerStatus[recentIndex- (j*self.__COLS)] == player:
            furthestUp-= self.__COLS
            j+=1

        i= 1
        while (recentIndex+ (i*self.__COLS)) <= high and self.__playerStatus[recentIndex+ (i*self.__COLS)] == player:
            furthestDown+= self.__COLS
            i+=1

        if (furthestDown % self.__ROWS) - (furthestUp % self.__ROWS) >= 3:
            return True
        else:
            return False
        
    def checkDiagLR(self, player, recentIndex):
        furthestLeft= recentIndex
        furthestRight= recentIndex
        while furthestLeft - (self.__COLS + 1) >= 0 and (furthestLeft - (self.__COLS + 1)) % self.__COLS >= 0 and self.__playerStatus[furthestLeft - (self.__COLS + 1)] == player:
            furthestLeft-= (self.__COLS + 1)
        while furthestRight + (self.__COLS + 1) < len(self.__playerStatus) and (furthestRight + (self.__COLS + 1)) % self.__COLS >= 0 and self.__playerStatus[furthestRight + (self.__COLS + 1)] == player:
            furthestRight += (self.__COLS + 1)
        if(furthestRight % self.__COLS) - (furthestLeft % self.__COLS) >= 3:
            return True
        else:
            return False

    def checkDiagRL(self, player, recentIndex):
        furthestLeft= recentIndex
        furthestRight= recentIndex
        while furthestRight - (self.__COLS - 1) >= 0 and (furthestRight - (self.__COLS - 1)) % self.__COLS >= 0 and self.__playerStatus[furthestRight - (self.__COLS - 1)] == player:
            furthestRight-= (self.__COLS - 1)
        while furthestLeft + (self.__COLS -1) < len(self.__playerStatus) and (furthestLeft + (self.__COLS - 1)) % self.__COLS >= 0 and self.__playerStatus[furthestLeft + (self.__COLS -1)] == player:
            furthestLeft += (self.__COLS - 1)
        if(furthestRight % self.__COLS) - (furthestLeft % self.__COLS) >= 3:
            return True
        else:
            return False

    def askMove(self):
        string= "Player " + str(self.__currentPlayer) + " choose which column you want to drop the disk down?"
        return string

    def getCurrent(self):
        return self.__currentPlayer

if __name__ == '__main__':   
    root= tk.Tk()
    root.title("Connect Four")
    game= GameBoard(root)

    frame= tk.Frame(root)
    frame.pack(side= tk.BOTTOM)
    game.beginGame()
    b0= tk.Button(frame, text= "0", command= lambda:game.dropDisk(0, game.getCurrent()))
    b0.pack(side= tk.LEFT)              
    b1= tk.Button(frame, text= "1", command= lambda:game.dropDisk(1, game.getCurrent()))
    b1.pack(side= tk.LEFT)
    b2= tk.Button(frame, text= "2", command= lambda:game.dropDisk(2, game.getCurrent()))
    b2.pack(side= tk.LEFT)
    b3= tk.Button(frame, text= "3", command= lambda:game.dropDisk(3, game.getCurrent()))
    b3.pack(side= tk.LEFT)
    b4= tk.Button(frame, text= "4", command= lambda:game.dropDisk(4, game.getCurrent()))
    b4.pack(side= tk.LEFT)
    b5= tk.Button(frame, text= "5", command= lambda:game.dropDisk(5, game.getCurrent()))
    b5.pack(side= tk.LEFT)
    b6= tk.Button(frame, text= "6", command= lambda:game.dropDisk(6, game.getCurrent()))
    b6.pack(side= tk.LEFT)
        
    tk.mainloop()
