#HW2 Q4 Chris Minda
#finds pairs of twin primes up to 1000

def findPrimes(n):
    p= []
    p.append(2)
    for i in range(2,n):
        if isPrime(i, p):
            p.append(i)
    return p

def isPrime(num, p):
    for prime in p:
        if num % prime == 0:
            return False

    return True

def twinPrimesUpTo(n):
    primes= findPrimes(n)
    i= 0
    print("Checking for twin primes.")
    j=0
    while i <  len(primes) - 1:
        if(primes[i] == primes[i+1] - 2):
            print("(", primes[i], ",", primes[i+1], ")")
            j+=1
        i+= 1
    print("Total number of twin prime pairs is ", j)

if __name__ == '__main__':

    twinPrimesUpTo(1000)
    print("Complete...")
