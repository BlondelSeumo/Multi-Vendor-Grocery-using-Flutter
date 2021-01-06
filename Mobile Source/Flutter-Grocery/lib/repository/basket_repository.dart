import 'dart:async';
import 'package:fluttermultigrocery/db/basket_dao.dart';
import 'package:fluttermultigrocery/viewobject/basket.dart';
import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/api/common/ps_resource.dart';
import 'package:fluttermultigrocery/api/common/ps_status.dart';

import 'Common/ps_repository.dart';

class BasketRepository extends PsRepository {
  BasketRepository({@required BasketDao basketDao}) {
    _basketDao = basketDao;
  }

  String primaryKey = 'id';
  BasketDao _basketDao;

  Future<dynamic> insert(Basket basket) async {
    return _basketDao.insert(primaryKey, basket);
  }

  Future<dynamic> update(Basket basket) async {
    return _basketDao.update(basket);
  }

  Future<dynamic> delete(Basket basket) async {
    return _basketDao.delete(basket);
  }

  // Future<dynamic> getAllBasketListByShopId(
  //     StreamController<PsResource<List<Basket>>> basketListStream,
  //     String shopId,
  //     PsStatus status) async {
  //   final Finder finder = Finder(filter: Filter.equals('shop_id', shopId));
  //   final dynamic subscription = _basketDao.getAllWithSubscription(
  //       status: PsStatus.SUCCESS,
  //       finder: finder,
  //       onDataUpdated: (List<Basket> productList) {
  //         if (status != null && status != PsStatus.NOACTION) {
  //           print(status);
  //           basketListStream.sink
  //               .add(PsResource<List<Basket>>(status, '', productList));
  //         } else {
  //           print('No Action');
  //         }
  //       });

  //   return subscription;
  // }

  Future<dynamic> getAllBasketList(
      StreamController<PsResource<List<Basket>>> basketListStream,
      PsStatus status) async {
    final dynamic subscription = _basketDao.getAllWithSubscription(
        status: PsStatus.SUCCESS,
        onDataUpdated: (List<Basket> productList) {
          if (status != null && status != PsStatus.NOACTION) {
            print(status);
            basketListStream.sink
                .add(PsResource<List<Basket>>(status, '', productList));
          } else {
            print('No Action');
          }
        });

    return subscription;
  }

  Future<dynamic> addAllBasket(
      StreamController<PsResource<List<Basket>>> basketListStream,
      PsStatus status,
      Basket basket) async {
    // final Finder finder =
    //     Finder(filter: Filter.equals('shop_id', basket.shopId));
    await _basketDao.insert(primaryKey, basket);
    basketListStream.sink.add(await _basketDao.getAll(status: status));
  }

  // Future<dynamic> addAllBasketByShopId(
  //     StreamController<PsResource<List<Basket>>> basketListStream,
  //     PsStatus status,
  //     Basket basket) async {
  //   await _basketDao.insert(primaryKey, basket);
  //   basketListStream.sink.add(await _basketDao.getAll(status: status));
  // }

  Future<dynamic> updateBasket(
      StreamController<PsResource<List<Basket>>> basketListStream,
      Basket product) async {
    await _basketDao.update(product);
    basketListStream.sink
        .add(await _basketDao.getAll(status: PsStatus.SUCCESS));
  }

  Future<dynamic> deleteBasketByProduct(
      StreamController<PsResource<List<Basket>>> basketListStream,
      Basket product) async {
    await _basketDao.delete(product);
    basketListStream.sink
        .add(await _basketDao.getAll(status: PsStatus.SUCCESS));
  }

  Future<dynamic> deleteWholeBasketList(
      StreamController<PsResource<List<Basket>>> basketListStream) async {
    await _basketDao.deleteAll();
  }
}
