import 'dart:async';
import 'package:fluttermultigrocery/constant/ps_constants.dart';
import 'package:fluttermultigrocery/db/shop_rating_dao.dart';
import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/api/common/ps_resource.dart';
import 'package:fluttermultigrocery/api/common/ps_status.dart';
import 'package:fluttermultigrocery/api/ps_api_service.dart';
import 'package:fluttermultigrocery/viewobject/shop_rating.dart';
import 'package:sembast/sembast.dart';

import 'Common/ps_repository.dart';

class ShopRatingRepository extends PsRepository {
  ShopRatingRepository(
      {@required PsApiService psApiService,
      @required ShopRatingDao shopRatingDao}) {
    _psApiService = psApiService;
    _shopRatingDao = shopRatingDao;
  }

  String primaryKey = 'id';
  PsApiService _psApiService;
  ShopRatingDao _shopRatingDao;

  Future<dynamic> insert(ShopRating shopRating) async {
    return _shopRatingDao.insert(primaryKey, shopRating);
  }

  Future<dynamic> update(ShopRating shopRating) async {
    return _shopRatingDao.update(shopRating);
  }

  Future<dynamic> delete(ShopRating shopRating) async {
    return _shopRatingDao.delete(shopRating);
  }

  Future<dynamic> getAllShopRatingList(
      StreamController<PsResource<List<ShopRating>>> shopRatingListStream,
      String shopId,
      bool isConnectedToInternet,
      int limit,
      int offset,
      PsStatus status,
      {bool isNeedDelete = true,
      bool isLoadFromServer = true}) async {
    final Finder finder = Finder(filter: Filter.equals('shop_id', shopId));
    shopRatingListStream.sink
        .add(await _shopRatingDao.getAll(finder: finder, status: status));

    if (isConnectedToInternet) {
      final PsResource<List<ShopRating>> _resource =
          await _psApiService.getShopRatingList(shopId, limit, offset);

      if (_resource.status == PsStatus.SUCCESS) {
        if (isNeedDelete) {
          await _shopRatingDao.deleteWithFinder(finder);
        }
        await _shopRatingDao.insertAll(primaryKey, _resource.data);
      } else {
        if (_resource.errorCode == PsConst.ERROR_CODE_10001) {
          await _shopRatingDao.deleteWithFinder(finder);
        }
      }
      shopRatingListStream.sink
          .add(await _shopRatingDao.getAll(finder: finder));
    }
  }

  Future<dynamic> getNextPageShopRatingList(
      StreamController<PsResource<List<ShopRating>>> shopRatingListStream,
      String shopId,
      bool isConnectedToInternet,
      int limit,
      int offset,
      PsStatus status,
      {bool isLoadFromServer = true}) async {
    final Finder finder = Finder(filter: Filter.equals('shop_id', shopId));
    shopRatingListStream.sink
        .add(await _shopRatingDao.getAll(finder: finder, status: status));

    if (isConnectedToInternet) {
      final PsResource<List<ShopRating>> _resource =
          await _psApiService.getShopRatingList(shopId, limit, offset);

      if (_resource.status == PsStatus.SUCCESS) {
        await _shopRatingDao.insertAll(primaryKey, _resource.data);
      }
      shopRatingListStream.sink
          .add(await _shopRatingDao.getAll(finder: finder));
    }
  }

  Future<PsResource<ShopRating>> postShopRating(
      StreamController<PsResource<List<ShopRating>>> shopRatingListStream,
      Map<dynamic, dynamic> jsonMap,
      bool isConnectedToInternet,
      {bool isLoadFromServer = true}) async {
    final PsResource<ShopRating> _resource =
        await _psApiService.postShopRating(jsonMap);
    if (_resource.status == PsStatus.SUCCESS) {
      shopRatingListStream.sink
          .add(await _shopRatingDao.getAll(status: PsStatus.SUCCESS));
      return _resource;
    } else {
      final Completer<PsResource<ShopRating>> completer =
          Completer<PsResource<ShopRating>>();
      completer.complete(_resource);
      shopRatingListStream.sink
          .add(await _shopRatingDao.getAll(status: PsStatus.SUCCESS));
      return completer.future;
    }
  }
}
