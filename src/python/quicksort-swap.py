import statistics

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


def swap(arr, i, j):
    if i == j:
        return arr

    # print('Swap', arr[i], arr[j])
    arr[i], arr[j] = arr[j], arr[i]
    return arr


class QuickSort:
    running_time = 0
    # 1: first element,
    # 2: last element,
    # 3: median-of-three
    pivot_settings = 1

    def run(self, arr):
        self.running_time = 0
        return self.sort_by_positions(arr, 0, len(arr) - 1)

    def sort_by_positions(self, arr, l, r):
        if len(arr) < 2:
            return arr, 0

        arr[l:r + 1] = self.move_pivot_to_begin(arr[l:r + 1])

        arr, splitter = self.partition(arr, l, r)

        if splitter > l:
            arr = self.sort_by_positions(arr, l, splitter - 1)

        if splitter < r:
            arr = self.sort_by_positions(arr, splitter + 1, r)

        return arr

    def partition(self, arr, l, r):
        pivot = arr[l]
        index = l + 1

        for j in range(l + 1, r + 1):
            if arr[j] < pivot:
                arr = swap(arr, index, j)
                index += 1

        new_pivot_index = index - 1
        arr = swap(arr, l, index - 1)
        self.running_time += r - l

        return arr, new_pivot_index

    def move_pivot_to_begin(self, numbers):
        if self.pivot_settings == 1:
            return numbers
        if self.pivot_settings == 2:
            return swap(numbers, 0, len(numbers) - 1)
        if self.pivot_settings == 3:
            index = get_index_of_median(numbers)
            return swap(numbers, 0, index)


for i in [1, 2, 3]:
    sort_input = inputs[:]

    sorter = QuickSort()

    sorter.pivot_settings = i

    print(sorter.run(sort_input))

    print(sorter.running_time)
