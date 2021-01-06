import 'dart:async';
import 'package:fluttermultigrocery/constant/ps_constants.dart';
import 'package:fluttermultigrocery/db/transaction_header_dao.dart';
import 'package:fluttermultigrocery/viewobject/transaction_header.dart';
import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/api/common/ps_resource.dart';
import 'package:fluttermultigrocery/api/common/ps_status.dart';
import 'package:fluttermultigrocery/api/ps_api_service.dart';
import 'package:sembast/sembast.dart';

import 'Common/ps_repository.dart';

class TransactionHeaderRepository extends PsRepository {
  TransactionHeaderRepository(
      {@required PsApiService psApiService,
      @required TransactionHeaderDao transactionHeaderDao}) {
    _psApiService = psApiService;
    _transactionHeaderDao = transactionHeaderDao;
  }

  String primaryKey = 'id';
  PsApiService _psApiService;
  TransactionHeaderDao _transactionHeaderDao;

  Future<dynamic> insert(TransactionHeader transaction) async {
    return _transactionHeaderDao.insert(primaryKey, transaction);
  }

  Future<dynamic> update(TransactionHeader transaction) async {
    return _transactionHeaderDao.update(transaction);
  }

  Future<dynamic> delete(TransactionHeader transaction) async {
    return _transactionHeaderDao.delete(transaction);
  }

  Future<dynamic> getAllTransactionList(
      StreamController<PsResource<List<TransactionHeader>>>
          transactionListStream,
      bool isConnectedToInternet,
      String loginUserId,
      int limit,
      int offset,
      PsStatus status,
      {bool isNeedDelete = true,
      bool isLoadFromServer = true}) async {
    final Finder finder = Finder(filter: Filter.equals('user_id', loginUserId));
    transactionListStream.sink.add(
        await _transactionHeaderDao.getAll(finder: finder, status: status));

    if (isConnectedToInternet) {
      final PsResource<List<TransactionHeader>> _resource =
          await _psApiService.getTransactionList(loginUserId, limit, offset);

      if (_resource.status == PsStatus.SUCCESS) {
        if (isNeedDelete) {
          await _transactionHeaderDao.deleteWithFinder(finder);
        }
        await _transactionHeaderDao.insertAll(primaryKey, _resource.data);
      } else {
        if (_resource.errorCode == PsConst.ERROR_CODE_10001) {
          await _transactionHeaderDao.deleteWithFinder(finder);
        }
      }
      transactionListStream.sink
          .add(await _transactionHeaderDao.getAll(finder: finder));
    }
  }

  Future<dynamic> getNextPageTransactionList(
      StreamController<PsResource<List<TransactionHeader>>>
          transactionListStream,
      bool isConnectedToInternet,
      String loginUserId,
      int limit,
      int offset,
      PsStatus status,
      {bool isNeedDelete = true,
      bool isLoadFromServer = true}) async {
    final Finder finder = Finder(filter: Filter.equals('user_id', loginUserId));
    transactionListStream.sink.add(
        await _transactionHeaderDao.getAll(finder: finder, status: status));

    if (isConnectedToInternet) {
      final PsResource<List<TransactionHeader>> _resource =
          await _psApiService.getTransactionList(loginUserId, limit, offset);

      if (_resource.status == PsStatus.SUCCESS) {
        await _transactionHeaderDao.insertAll(primaryKey, _resource.data);
      }
      transactionListStream.sink.add(await _transactionHeaderDao.getAll());
    }
  }

  Future<PsResource<TransactionHeader>> postTransactionSubmit(
      Map<dynamic, dynamic> jsonMap,
      bool isConnectedToInternet,
      PsStatus status,
      {bool isLoadFromServer = true}) async {
    final String jsonMapData = jsonMap.toString();
    print(jsonMapData);

    final PsResource<TransactionHeader> _resource =
        await _psApiService.postTransactionSubmit(jsonMap);
    if (_resource.status == PsStatus.SUCCESS) {
      return _resource;
    } else {
      final Completer<PsResource<TransactionHeader>> completer =
          Completer<PsResource<TransactionHeader>>();
      completer.complete(_resource);
      return completer.future;
    }
  }
}
