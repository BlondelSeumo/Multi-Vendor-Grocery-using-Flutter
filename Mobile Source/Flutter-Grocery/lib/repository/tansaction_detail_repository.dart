import 'dart:async';
import 'package:fluttermultigrocery/constant/ps_constants.dart';
import 'package:fluttermultigrocery/db/transaction_detail_dao.dart';
import 'package:fluttermultigrocery/viewobject/transaction_detail.dart';
import 'package:fluttermultigrocery/viewobject/transaction_header.dart';
import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/api/common/ps_resource.dart';
import 'package:fluttermultigrocery/api/common/ps_status.dart';
import 'package:fluttermultigrocery/api/ps_api_service.dart';
import 'package:sembast/sembast.dart';

import 'Common/ps_repository.dart';

class TransactionDetailRepository extends PsRepository {
  TransactionDetailRepository(
      {@required PsApiService psApiService,
      @required TransactionDetailDao transactionDetailDao}) {
    _psApiService = psApiService;
    _transactionDetailDao = transactionDetailDao;
  }

  String primaryKey = 'id';
  PsApiService _psApiService;
  TransactionDetailDao _transactionDetailDao;

  Future<dynamic> insert(TransactionDetail transaction) async {
    return _transactionDetailDao.insert(primaryKey, transaction);
  }

  Future<dynamic> update(TransactionDetail transaction) async {
    return _transactionDetailDao.update(transaction);
  }

  Future<dynamic> delete(TransactionDetail transaction) async {
    return _transactionDetailDao.delete(transaction);
  }

  Future<dynamic> getAllTransactionDetailList(
      StreamController<PsResource<List<TransactionDetail>>>
          transactionDetailListStream,
      TransactionHeader transaction,
      bool isConnectedToInternet,
      int limit,
      int offset,
      PsStatus status,
      {bool isLoadFromServer = true}) async {
    final Finder finder =
        Finder(filter: Filter.equals('transactions_header_id', transaction.id));
    transactionDetailListStream.sink.add(
        await _transactionDetailDao.getAll(finder: finder, status: status));

    if (isConnectedToInternet) {
      final PsResource<List<TransactionDetail>> _resource = await _psApiService
          .getTransactionDetail(transaction.id, limit, offset);

      if (_resource.status == PsStatus.SUCCESS) {
        await _transactionDetailDao.deleteWithFinder(finder);
        await _transactionDetailDao.insertAll(primaryKey, _resource.data);
      } else {
        if (_resource.errorCode == PsConst.ERROR_CODE_10001) {
          await _transactionDetailDao.deleteWithFinder(finder);
        }
      }
      transactionDetailListStream.sink
          .add(await _transactionDetailDao.getAll(finder: finder));
    }
  }

  Future<dynamic> getNextPageTransactionDetailList(
      StreamController<PsResource<List<TransactionDetail>>>
          transactionDetailListStream,
      TransactionHeader transaction,
      bool isConnectedToInternet,
      int limit,
      int offset,
      PsStatus status,
      {bool isLoadFromServer = true}) async {
    final Finder finder =
        Finder(filter: Filter.equals('transactions_header_id', transaction.id));
    transactionDetailListStream.sink.add(
        await _transactionDetailDao.getAll(finder: finder, status: status));

    if (isConnectedToInternet) {
      final PsResource<List<TransactionDetail>> _resource = await _psApiService
          .getTransactionDetail(transaction.id, limit, offset);

      if (_resource.status == PsStatus.SUCCESS) {
        await _transactionDetailDao.insertAll(primaryKey, _resource.data);
      }
      transactionDetailListStream.sink
          .add(await _transactionDetailDao.getAll(finder: finder));
    }
  }
}
