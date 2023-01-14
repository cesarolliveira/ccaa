<?php

namespace App\Repository;

use DateTime;
use App\Entity\Lancamento;
use App\Enum\SituacaoLancamentoEnum;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Lancamento>
 *
 * @method Lancamento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lancamento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lancamento[]    findAll()
 * @method Lancamento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LancamentoRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry
    ) {
        parent::__construct($registry, Lancamento::class);
    }

    public function save(Lancamento $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Lancamento $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findLancamentosMesAtual(): array
    {
        $qb = $this->createQueryBuilder('lancamento');

        $expr = $qb->expr();

        $qb
            ->andWhere($expr->between('lancamento.vencimento', ':diaInicioMesAtual', ':diaFinalMesAtual'))
            ->setParameter('diaInicioMesAtual', new \DateTime('first day of this month'))
            ->setParameter('diaFinalMesAtual', new \DateTime('last day of this month'))
        ;

        return $qb->getQuery()->getResult();
    }

    public function findLancamentosMesAtualPendentes(): array
    {
        $qb = $this->createQueryBuilder('lancamento');

        $expr = $qb->expr();

        $qb
            ->andWhere($expr->between('lancamento.vencimento', ':diaInicioMesAtual', ':diaFinalMesAtual'))
            ->andWhere($expr->eq('lancamento.situacao', ':pendente'))
            ->setParameter('diaInicioMesAtual', new \DateTime('first day of this month'))
            ->setParameter('diaFinalMesAtual', new \DateTime('last day of this month'))
            ->setParameter('pendente', SituacaoLancamentoEnum::PENDENTE)
        ;

        return $qb->getQuery()->getResult();
    }

    public function findLancamentosMesAtualPagos(): array
    {
        $qb = $this->createQueryBuilder('lancamento');

        $expr = $qb->expr();

        $qb
            ->andWhere($expr->between('lancamento.vencimento', ':diaInicioMesAtual', ':diaFinalMesAtual'))
            ->andWhere($expr->eq('lancamento.situacao', ':pago'))
            ->setParameter('diaInicioMesAtual', new \DateTime('first day of this month'))
            ->setParameter('diaFinalMesAtual', new \DateTime('last day of this month'))
            ->setParameter('pago', SituacaoLancamentoEnum::PAGO)
        ;

        return $qb->getQuery()->getResult();
    }

    public function findLancamentosMesAtualVencidos(): array
    {
        $qb = $this->createQueryBuilder('lancamento');

        $expr = $qb->expr();

        $qb
            ->andWhere($expr->lt('lancamento.vencimento', ':diaAtual'))
            ->andWhere($expr->eq('lancamento.situacao', ':pendente'))
            ->setParameter('diaAtual', new \DateTime('today'))
            ->setParameter('pendente', SituacaoLancamentoEnum::VENCIDO)
        ;

        return $qb->getQuery()->getResult();
    }

    public function findLancamentosDoDia(): array
    {
        $qb = $this->createQueryBuilder('lancamento');

        $expr = $qb->expr();

        $qb
            ->andWhere($expr->eq('lancamento.vencimento', ':diaAtual'))
            ->setParameter('diaAtual', new \DateTime('today'))
        ;

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Lancamento[] Returns an array of Lancamento objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Lancamento
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
