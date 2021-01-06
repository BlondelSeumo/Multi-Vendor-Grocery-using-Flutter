import 'dart:async';

import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/api/common/ps_resource.dart';
import 'package:fluttermultigrocery/api/common/ps_status.dart';
import 'package:fluttermultigrocery/api/ps_api_service.dart';
import 'package:fluttermultigrocery/constant/ps_constants.dart';
import 'package:fluttermultigrocery/db/shop_dao.dart';
import 'package:fluttermultigrocery/db/shop_map_dao.dart';
import 'package:fluttermultigrocery/repository/Common/ps_repository.dart';
import 'package:fluttermultigrocery/viewobject/api_status.dart';
import 'package:fluttermultigrocery/viewobject/holder/shop_parameter_holder.dart';
import 'package:fluttermultigrocery/viewobject/shop.dart';
import 'package:fluttermultigrocery/viewobject/shop_map.dart';
import 'package:sembast/sembast.dart';

class ShopRepository extends PsRepository {
  ShopRepository(
      {@required PsApiService psApiService, @required ShopDao shopDao}) {
    _psApiService = psApiService;
    _shopDao = shopDao;
  }
  String primaryKey = 'id';
  String mapKey = 'map_key';
  String tagIdKey = 'tag_id';
  PsApiService _psApiService;
  ShopDao _shopDao;

  void sinkShopListStream(
      StreamController<PsResource<List<Shop>>> shopListStream,
      PsResource<List<Shop>> dataList) {
    if (dataList != null && shopListStream != null) {
      shopListStream.sink.add(dataList);
    }
  }

  void sinkShopListByTagIdStream(
      StreamController<PsResource<List<Shop>>> shopListByTagIdStream,
      PsResource<List<Shop>> dataList) {
    if (dataList != null && shopListByTagIdStream != null) {
      shopListByTagIdStream.sink.add(dataList);
    }
  }

  Future<dynamic> insert(Shop shop) async {
    return _shopDao.insert(primaryKey, shop);
  }

  Future<dynamic> update(Shop shop) async {
    return _shopDao.update(shop);
  }

  Future<dynamic> delete(Shop shop) async {
    return _shopDao.delete(shop);
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

  Future<dynamic> getShopList(
      StreamController<PsResource<List<Shop>>> shopListStream,
      bool isConnectedToInternet,
      int limit,
      int offset,
      PsStatus status,
      ShopParameterHolder holder,
      {bool isLoadFromServer = true}) async {
    // Prepare Holder and Map Dao
    final String paramKey = holder.getParamKey();
    final ShopMapDao shopMapDao = ShopMapDao.instance;

    // Load from Db and Send to UI
    sinkShopListStream(
        shopListStream,
        await _shopDao.getAllByMap(
            primaryKey, mapKey, paramKey, shopMapDao, ShopMap(),
            status: status));

    // Server Call
    if (isConnectedToInternet) {
      final PsResource<List<Shop>> _resource =
          await _psApiService.getShopList(holder.toMap(), limit, offset);

      print('Param Key $paramKey');
      if (_resource.status == PsStatus.SUCCESS) {
        // Create Map List
        final List<ShopMap> shopMapList = <ShopMap>[];
        int i = 0;
        for (Shop data in _resource.data) {
          shopMapList.add(ShopMap(
              id: data.id + paramKey,
              mapKey: paramKey,
              shopId: data.id,
              sorting: i++,
              addedDate: '2020'));
        }

        // Delete and Insert Map Dao
        print('Delete Key $paramKey');
        await shopMapDao
            .deleteWithFinder(Finder(filter: Filter.equals(mapKey, paramKey)));
        print('Insert All Key $paramKey');
        await shopMapDao.insertAll(primaryKey, shopMapList);

        // Insert Shop
        await _shopDao.insertAll(primaryKey, _resource.data);

        // sinkShopListStream(
        //     shopListStream,
        //     await _shopDao.getAllByMap(
        //         primaryKey, mapKey, paramKey, shopMapDao, ShopMap()));

      } else {
        if (_resource.errorCode == PsConst.ERROR_CODE_10001) {
          await shopMapDao.deleteWithFinder(
              Finder(filter: Filter.equals(mapKey, paramKey)));
        }
      }
      // Load updated Data from Db and Send to UI
      sinkShopListStream(
          shopListStream,
          await _shopDao.getAllByMap(
              primaryKey, mapKey, paramKey, shopMapDao, ShopMap()));
    }
  }

  Future<dynamic> getNextPageShopList(
      StreamController<PsResource<List<Shop>>> shopListStream,
      bool isConnectedToInternet,
      int limit,
      int offset,
      PsStatus status,
      ShopParameterHolder holder,
      {bool isLoadFromServer = true}) async {
    final String paramKey = holder.getParamKey();
    final ShopMapDao shopMapDao = ShopMapDao.instance;
    // Load from Db and Send to UI
    sinkShopListStream(
        shopListStream,
        await _shopDao.getAllByMap(
            primaryKey, mapKey, paramKey, shopMapDao, ShopMap(),
            status: status));
    if (isConnectedToInternet) {
      final PsResource<List<Shop>> _resource =
          await _psApiService.getShopList(holder.toMap(), limit, offset);

      if (_resource.status == PsStatus.SUCCESS) {
        // Create Map List
        final List<ShopMap> shopMapList = <ShopMap>[];
        final PsResource<List<ShopMap>> existingMapList = await shopMapDao
            .getAll(finder: Finder(filter: Filter.equals(mapKey, paramKey)));

        int i = 0;
        if (existingMapList != null) {
          i = existingMapList.data.length + 1;
        }
        for (Shop data in _resource.data) {
          shopMapList.add(ShopMap(
              id: data.id + paramKey,
              mapKey: paramKey,
              shopId: data.id,
              sorting: i++,
              addedDate: '2019'));
        }

        await shopMapDao.insertAll(primaryKey, shopMapList);

        // Insert Shop
        await _shopDao.insertAll(primaryKey, _resource.data);
      }
      sinkShopListStream(
          shopListStream,
          await _shopDao.getAllByMap(
              primaryKey, mapKey, paramKey, shopMapDao, ShopMap()));
    }
  }

  ///Shop list By Collection Id

  // Future<dynamic> getShopListByTagId(
  //     StreamController<PsResource<List<Shop>>> shopListStream,
  //     bool isConnectedToInternet,
  //     String tagId,
  //     int limit,
  //     int offset,
  //     PsStatus status,
  //     {bool isLoadFromServer = true}) async {
  //   final Finder finder = Finder(filter: Filter.equals(tagIdKey, tagId));
  //   final ShopListByTagIdDao shopListByTagIdDao = ShopListByTagIdDao.instance;

  //   // Load from Db and Send to UI
  //   sinkShopListByTagIdStream(
  //       shopListStream,
  //       await _shopDao.getAllDataListWithFilterId(
  //           tagId, tagIdKey, shopListByTagIdDao, ShopListByTagId(),
  //           status: status));

  //   // Server Call
  //   if (isConnectedToInternet) {
  //     final PsResource<List<Shop>> _resource =
  //         await _psApiService.getShopListByTagId(
  //       limit,
  //       offset,
  //       tagId,
  //     );

  //     if (_resource.status == PsStatus.SUCCESS) {
  //       // Create Map List
  //       final List<ShopListByTagId> shopMapList = <ShopListByTagId>[];
  //       int i = 0;
  //       for (Shop data in _resource.data) {
  //         shopMapList.add(ShopListByTagId(
  //           tagId: tagId,
  //           id: data.id,
  //           sorting: i++,
  //         ));
  //       }

  //       // Delete and Insert Map Dao
  //       await shopListByTagIdDao.deleteWithFinder(finder);
  //       await shopListByTagIdDao.insertAll(primaryKey, shopMapList);

  //       // Insert Shop
  //       await _shopDao.insertAll(primaryKey, _resource.data);
  //     }
  //     // Load updated Data from Db and Send to UI

  //     sinkShopListByTagIdStream(
  //         shopListStream,
  //         await _shopDao.getAllDataListWithFilterId(
  //             tagId, tagIdKey, shopListByTagIdDao, ShopListByTagId()));

  //     Utils.psPrint('End of Collection Shop');
  //   }
  // }

  // Future<dynamic> getNextPageShopListByTagId(
  //     StreamController<PsResource<List<Shop>>> shopListStream,
  //     bool isConnectedToInternet,
  //     String tagId,
  //     int limit,
  //     int offset,
  //     PsStatus status,
  //     {bool isLoadFromServer = true}) async {
  //   final Finder finder = Finder(filter: Filter.equals(tagIdKey, tagId));
  //   final ShopListByTagIdDao shopListByTagIdDao = ShopListByTagIdDao.instance;
  //   // Load from Db and Send to UI
  //   sinkShopListByTagIdStream(
  //       shopListStream,
  //       await _shopDao.getAllDataListWithFilterId(
  //           tagId, tagIdKey, shopListByTagIdDao, ShopListByTagId(),
  //           status: status));

  //   if (isConnectedToInternet) {
  //     final PsResource<List<Shop>> _resource =
  //         await _psApiService.getShopListByTagId(limit, offset, tagId);

  //     if (_resource.status == PsStatus.SUCCESS) {
  //       // Create Map List
  //       final List<ShopListByTagId> shopMapList = <ShopListByTagId>[];
  //       final PsResource<List<ShopListByTagId>> existingMapList =
  //           await shopListByTagIdDao.getAll(finder: finder);

  //       int i = 0;
  //       if (existingMapList != null) {
  //         i = existingMapList.data.length + 1;
  //       }
  //       for (Shop data in _resource.data) {
  //         shopMapList.add(ShopListByTagId(
  //           id: data.id,
  //           tagId: tagId,
  //           sorting: i++,
  //         ));
  //       }

  //       await shopListByTagIdDao.insertAll(primaryKey, shopMapList);

  //       // Insert Shop
  //       await _shopDao.insertAll(primaryKey, _resource.data);
  //     }
  //     sinkShopListByTagIdStream(
  //         shopListStream,
  //         await _shopDao.getAllDataListWithFilterId(
  //             tagId, tagIdKey, shopListByTagIdDao, ShopListByTagId()));
  //     Utils.psPrint('End of Collection Shop');
  //   }
  // }
}
