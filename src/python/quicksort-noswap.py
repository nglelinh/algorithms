import statistics

# 1: first element, 2: last element, 3: median-of-three
pivot_settings = 3
inputs = []

with open('/home/nglelinh/Downloads/QuickSort.txt') as f:
    for line in f:
        inputs.append(int(line))


def get_index_of_median(numbers):
    a, b, c = numbers[0], numbers[int((len(numbers) - 1) / 2)], numbers[-1]
    median = statistics.median([a, b, c])
    if b == median:
        return int((len(numbers) - 1) / 2)
    if a == median:
        return 0
    if c == median:
        return len(numbers) - 1


def choose_pivot_element(numbers):
    if pivot_settings == 1:
        return numbers[0], numbers[1:]
    if pivot_settings == 2:
        return numbers[-1], numbers[:-1]
    if pivot_settings == 3:
        index = get_index_of_median(numbers)
        pivot = numbers[index]
        return pivot, [value for i, value in enumerate(numbers) if i != index]


def sort_and_count_comparisons(numbers):
    if len(numbers) < 2:
        return numbers, 0

    left, pivot, right = subroutine(numbers)
    left, left_count = sort_and_count_comparisons(left)
    right, right_count = sort_and_count_comparisons(right)

    return left + [pivot] + right, left_count + right_count + len(numbers) - 1


def subroutine(numbers):
    pivot, sub_array = choose_pivot_element(numbers)
    left = []
    right = []
    for numb in sub_array:
        if numb > pivot:
            right.append(numb)
        else:
            left.append(numb)
    return left, pivot, right


test = [3, 9, 8, 4, 6, 10, 2, 5, 7, 1]

for i in [1, 2, 3]:
    pivot_settings = i

    sorted_array, count = sort_and_count_comparisons(test)

    print(sorted_array)

    print(count)
