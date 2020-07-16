<?php

namespace App\Traits;

trait Pagination
{
    public static function paginate($request, $data, $key = [])
    {
        /**
         * uri e.g: ?pageSize=2&page=0&sorted[0][id]=field_name&sorted[0][desc]=false&filtered[0][id]=bundle_name&filtered[0][value]=et
         * 1. user need to provide pagesize and page number
         * 2. to sort, user need to provide fieldname and the descending value either true or false
         * 3. to filter, user need to provide fieldname and the value you want to search.
         */
        $validated = $request->validate([
            'pageSize' => 'required_with:page|numeric|integer|gte:0',
            'page' => 'required_with:pageSize|numeric|integer|gte:0',
            'sorted' => 'sometimes|array',
            'sorted.*.id' => 'required|in:' . implode(',', $key),
            'sorted.*.desc' => 'required|in:true,false',
            'filtered' => 'sometimes|array',
            'filtered.*.id' => 'required|in:' . implode(',', $key),
            'filtered.*.value' => 'required',
        ]);

        if (isset($validated['filtered']) && count($validated['filtered']) > 0) {
            foreach ($validated['filtered'] as $item) {
                $data = $data->where($item['id'], 'like', '%' . $item['value'] . '%');
            }
        }

        if (isset($validated['sorted']) && count($validated['sorted']) > 0) {
            foreach ($validated['sorted'] as $item) {
                $data = $data->orderBy($item['id'], $item['desc'] == "true" ? 'desc' : 'asc');
            }
        }

        $count = $data->count();

        $page = isset($validated['page']) ? $validated['page'] : 0;
        $pageSize = isset($validated['pageSize']) ? $validated['pageSize'] : 100;

        $data = $data->offset($page * $pageSize);

        $data = $data->limit($pageSize);

        $data = $data->get();

        return ['data' => $data, 'count' => $count];
    }
}
