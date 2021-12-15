from pyspark import SparkContext
from collections import defaultdict
from itertools import combinations

def generBookPairs(bookList):
    return list(combinations(bookList, 2))

def convertIntSort(pair):
    b1, b2 = pair
    iB1 = int(b1)
    iB2 = int(b2)
    if iB1 > iB2:
        tmp = iB1
        iB1 = iB2
        iB2 = tmp
    return iB1, iB2

sc = SparkContext("local", "bookPairs")
lines = sc.textFile("/home/cs143/data/goodreads.user.books")
books = lines.map(lambda line: line.split(":")[1])
bookList = books.map(lambda line: line.split(","))
bookPairs = bookList.flatMap(lambda listBook: generBookPairs(listBook))
castSortedBookPairs = bookPairs.map(lambda pair: convertIntSort(pair))
countBookPairs = castSortedBookPairs.map(lambda pair: (pair, 1))
sumCountBookPairs = countBookPairs.reduceByKey(lambda p1, p2: p1+p2)
filtPairs = sumCountBookPairs.filter(lambda val: val[1] > 20)
filtPairs.saveAsTextFile("output")