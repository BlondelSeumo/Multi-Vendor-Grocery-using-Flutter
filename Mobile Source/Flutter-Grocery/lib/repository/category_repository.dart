import 'dart:async';
import 'package:fluttermultigrocery/constant/ps_constants.dart';
import 'package:fluttermultigrocery/db/category_map_dao.dart';
import 'package:fluttermultigrocery/viewobject/api_status.dart';
import 'package:fluttermultigrocery/viewobject/category_map.dart';
import 'package:fluttermultigrocery/viewobject/holder/category_parameter_holder.dart';
import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/api/common/ps_resource.dart';
import 'package:fluttermultigrocery/api/common/ps_status.dart';
import 'package:fluttermultigrocery/api/ps_api_service.dart';
import 'package:fluttermultigrocery/db/cateogry_dao.dart';
import 'package:fluttermultigrocery/viewobject/category.dart';
import 'package:sembast/sembast.dart';
import 'Common/ps_repository.dart';

class CategoryRepository extends PsRepository {
  CategoryRepository(
      {@required PsApiService psApiService,
      @required CategoryDao categoryDao}) {
    _psApiService = psApiService;
    _categoryDao = categoryDao;
  }

  String primaryKey = 'id';
  String mapKey = 'map_key';
  PsApiService _psApiService;
  CategoryDao _categoryDao;

  void sinkCategoryListStream(
      StreamController<PsResource<List<Category>>> categoryListStream,
      PsResource<List<Category>> dataList) {
    if (dataList != null && categoryListStream != null) {
      categoryListStream.sink.add(dataList);
    }
  }

  Future<dynamic> insert(Category category) async {
    return _categoryDao.insert(primaryKey, category);
  }

  Future<dynamic> update(Category category) async {
    return _categoryDao.update(category);
  }

  Future<dynamic> delete(Category category) async {
    return _categoryDao.delete(category);
  }

  Future<dynamic> getCategoryList(
      StreamController<PsResource<List<Category>>> categoryListStream,
      bool isConnectedToInternet,
      int limit,
      int offset,
      CategoryParameterHolder holder,
      PsStatus status,
      {bool isLoadFromServer = true}) async {
    // Prepare Holder and Map Dao
    final String paramKey = holder.getParamKey();
    final CategoryMapDao categoryMapDao = CategoryMapDao.instance;

    sinkCategoryListStream(
        categoryListStream,
        await _categoryDao.getAllByMap(
            primaryKey, mapKey, paramKey, categoryMapDao, CategoryMap(),
            status: status));

    if (isConnectedToInternet) {
      final PsResource<List<Category>> _resource =
          await _psApiService.getCategoryList(limit, offset, holder.toMap());

      if (_resource.status == PsStatus.SUCCESS) {
        final List<CategoryMap> categoryMapList = <CategoryMap>[];
        int i = 0;
        for (Category data in _resource.data) {
          categoryMapList.add(CategoryMap(
              id: data.id + paramKey,
              mapKey: paramKey,
              categoryId: data.id,
              sorting: i++,
              addedDate: '2019'));
        }

        // Delete and Insert Map Dao
        await categoryMapDao
            .deleteWithFinder(Finder(filter: Filter.equals(mapKey, paramKey)));
        await categoryMapDao.insertAll(primaryKey, categoryMapList);

        // Insert Category
        await _categoryDao.insertAll(primaryKey, _resource.data);
      } else {
        if (_resource.errorCode == PsConst.ERROR_CODE_10001) {
          await categoryMapDao.deleteWithFinder(
              Finder(filter: Filter.equals(mapKey, paramKey)));
        }
      }
      // Load updated Data from Db and Send to UI
      sinkCategoryListStream(
          categoryListStream,
          await _categoryDao.getAllByMap(
              primaryKey, mapKey, paramKey, categoryMapDao, CategoryMap()));
    }
  }

  Future<dynamic> getAllCategoryList(
      StreamController<PsResource<List<Category>>> categoryListStream,
      bool isConnectedToInternet,
      CategoryParameterHolder holder,
      PsStatus status,
      {bool isLoadFromServer = true}) async {
    // Prepare Holder and Map Dao
    final String paramKey = holder.getParamKey();
    final CategoryMapDao categoryMapDao = CategoryMapDao.instance;

    sinkCategoryListStream(
        categoryListStream,
        await _categoryDao.getAllByMap(
            primaryKey, mapKey, paramKey, categoryMapDao, CategoryMap(),
            status: status));

    if (isConnectedToInternet) {
      final PsResource<List<Category>> _resource =
          await _psApiService.getAllCategoryList(holder.toMap());

      if (_resource.status == PsStatus.SUCCESS) {
        final List<CategoryMap> categoryMapList = <CategoryMap>[];
        int i = 0;
        for (Category data in _resource.data) {
          categoryMapList.add(CategoryMap(
              id: data.id + paramKey,
              mapKey: paramKey,
              categoryId: data.id,
              sorting: i++,
              addedDate: '2019'));
        }

        // Delete and Insert Map Dao
        await categoryMapDao
            .deleteWithFinder(Finder(filter: Filter.equals(mapKey, paramKey)));
        await categoryMapDao.insertAll(primaryKey, categoryMapList);

        // Insert Category
        await _categoryDao.insertAll(primaryKey, _resource.data);
      } else {
        if (_resource.errorCode == PsConst.ERROR_CODE_10001) {
          await categoryMapDao.deleteWithFinder(
              Finder(filter: Filter.equals(mapKey, paramKey)));
        }
      }
      // Load updated Data from Db and Send to UI
      sinkCategoryListStream(
          categoryListStream,
          await _categoryDao.getAllByMap(
              primaryKey, mapKey, paramKey, categoryMapDao, CategoryMap()));
    }
  }

  Future<dynamic> getNextPageCategoryList(
      StreamController<PsResource<List<Category>>> categoryListStream,
      bool isConnectedToInternet,
      int limit,
      int offset,
      CategoryParameterHolder holder,
      PsStatus status,
      {bool isLoadFromServer = true}) async {
    // Prepare Holder and Map Dao
    final String paramKey = holder.getParamKey();
    final CategoryMapDao categoryMapDao = CategoryMapDao.instance;

    sinkCategoryListStream(
        categoryListStream,
        await _categoryDao.getAllByMap(
            primaryKey, mapKey, paramKey, categoryMapDao, CategoryMap(),
            status: status));

    if (isConnectedToInternet) {
      final PsResource<List<Category>> _resource =
          await _psApiService.getCategoryList(limit, offset, holder.toMap());

      if (_resource.status == PsStatus.SUCCESS) {
        final List<CategoryMap> categoryMapList = <CategoryMap>[];
        final PsResource<List<CategoryMap>> existingMapList =
            await categoryMapDao.getAll(
                finder: Finder(filter: Filter.equals(mapKey, paramKey)));

        int i = 0;
        if (existingMapList != null) {
          i = existingMapList.data.length + 1;
        }
        for (Category data in _resource.data) {
          categoryMapList.add(CategoryMap(
              id: data.id + paramKey,
              mapKey: paramKey,
              categoryId: data.id,
              sorting: i++,
              addedDate: '2019'));
        }

        await categoryMapDao.insertAll(primaryKey, categoryMapList);

        await _categoryDao.insertAll(primaryKey, _resource.data);
      }
      sinkCategoryListStream(
          categoryListStream,
          await _categoryDao.getAllByMap(
              primaryKey, mapKey, paramKey, categoryMapDao, CategoryMap()));
    }
  }

  Future<PsResource<ApiStatus>> postTouchCount(Map<dynamic, dynamic> jsonMap,
      bool isConnectedToInternet, PsStatus status,
      {bool isLoadFromServer = true}) async {
    final PsResource<ApiStatus> _resource =
        await _psApiService.postTouchCount(jsonMap);
    if (_resource.status == PsStatus.SUCCESS) {
      return _resource;
    } else {
      final Completer<PsResource<ApiStatus>> completer =
          Completer<PsResource<ApiStatus>>();
      completer.complete(_resource);
      return completer.future;
    }
  }
}
