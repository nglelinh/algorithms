# sort the array using mergesort, meanwhile count the number of inversions

input_numbers = []

with open('/home/nglelinh/Downloads/IntegerArray.txt') as f:
    for line in f:
        input_numbers.append(int(line))


def sort_and_count_inversions(numbers):
    if len(numbers) < 2:
        return numbers, 0

    left, left_count = sort_and_count_inversions(numbers[:int(len(numbers) / 2)])
    right, right_count = sort_and_count_inversions(numbers[int(len(numbers) / 2):])
    merged, split_count = merge_split(left, right)

    print(left, right)

    return merged, left_count + right_count + split_count


def merge_split(left, right):
    left_i = right_i = inversions = 0
    sorted_list = []

    for i in range(len(left) + len(right)):
        if left_i == len(left):
            sorted_list.append(right[right_i])
            right_i += 1
            continue

        if right_i == len(right):
            sorted_list.append(left[left_i])
            left_i += 1
            continue

        if left[left_i] < right[right_i]:
            sorted_list.append(left[left_i])
            left_i += 1
        else:
            sorted_list.append(right[right_i])
            right_i += 1
            inversions += len(left) - left_i

    return sorted_list, inversions


# merged_list, count = merge_split([2, 3, 5, 8], [1, 4, 6])
#
# print(merged_list)
#
# print(count)
#
# merged_list, count = sort_and_count_inversions(input_numbers)
#
# print(input_numbers[:10])
#
# print(count)


inputs = [5, 3, 8, 9, 1, 7, 0, 2, 6, 4]

merged_list, count = sort_and_count_inversions(inputs)

print(merged_list)

print(count)